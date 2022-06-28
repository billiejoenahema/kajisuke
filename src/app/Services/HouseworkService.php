<?php

namespace App\Services;

use App\Http\Requests\Housework\StoreRequest;
use App\Models\Housework;
use App\Models\HouseworkOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HouseworkService
{
    /**
     * 家事の次回実施日を更新する。
     *
     * @param mixed $archive
     * @return void
     */
    public function updateNextDate($archive): void
    {
        $housework = Housework::findOrFail($archive->housework_id);
        $cycle = [
            'num' => $housework->cycle_num,
            'unit' => $housework->cycle_unit,
        ];
        $housework->next_date = self::getNextDate($archive->date, $cycle);

        $housework->save();
    }

    /**
     * 家事の次回実施日を返します。
     *
     * @param string $archiveDate
     * @param array $cycle
     *
     * @return object
     */
    public function getNextDate($archiveDate, $cycle): object
    {
        switch ($cycle['unit']) {
            case Housework::DAY['ID']:
                return Carbon::parse($archiveDate)->addDays($cycle['num']);
                break;
            case Housework::WEEK['ID']:
                return Carbon::parse($archiveDate)->addWeeks($cycle['num']);
                break;
            case Housework::MONTH['ID']:
                return Carbon::parse($archiveDate)->addMonths($cycle['num']);
                break;
            case Housework::YEAR['ID']:
                return Carbon::parse($archiveDate)->addYears($cycle['num']);
                break;
        }
    }

    /**
     * 家事を新規登録する。
     *
     * @param StoreRequest $request
     * @return Housework
     */
    public static function store(StoreRequest $request): Housework
    {
        $housework = DB::transaction(function () use ($request) {
            // 家事を新規登録する
            $housework = Housework::create([
                'user_id' => Auth::user()->id,
                'title' => $request['title'],
                'comment' => $request['comment'],
                'cycle_num' => $request['cycle_num'],
                'cycle_unit' => $request['cycle_unit'],
                'next_date' => $request->nextDate(),
                'category_id' => $request->category_id,
            ]);

            // 家事の表示順に家事IDを追加する
            self::attachHouseworkOrder($housework);

            return $housework;
        });

        return $housework;
    }

    /**
     * 家事を更新する。
     *
     * @param StoreHouseworkRequest $request
     * @return Housework
     */
    public static function update($request): Housework
    {
        $housework = DB::transaction(function () use ($request) {
            $housework = Housework::findOrFail($request['id']);

            $housework->category_id = $request['category_id'];
            $housework->title = $request['title'];
            $housework->comment = $request['comment'];
            $housework->cycle_num = $request['cycle_num'];
            $housework->cycle_unit = $request['cycle_unit'];
            $housework->next_date = $request->nextDate();
            $housework->save();

            return $housework;
        });

        return $housework;
    }

    /**
     * 家事を削除する。
     *
     * @param StoreHouseworkRequest $request
     * @return void
     */
    public static function destroy($id): void
    {
        DB::transaction(function () use ($id) {
            $housework = Housework::findOrFail($id);
            self::detachHouseOrder($id);
            $housework->delete();
        });
    }

    /**
     * 家事の表示順から指定した家事IDを取り除く。
     *
     * @param Int $id
     * @return void
     */
    public static function detachHouseOrder($id): void
    {
        // ユーザーが所有する家事の表示順を取得する
        $houseworkOrder = HouseworkOrder::where('user_id', Auth::user()->id)->first();
        // 家事の表示順を配列に変換する
        $orderArray = explode(',', $houseworkOrder->order);
        // 配列から家事IDを取り除く
        $filteredOrder = array_filter($orderArray, function ($value) use ($id) {
            return $value != $id;
        });
        // 配列をカンマで連結して文字列に変換する
        $orderString = implode(',', $filteredOrder);

        // 家事の表示順を更新する
        $houseworkOrder->order = $orderString;
        $houseworkOrder->save();
    }

    /**
     * 家事の表示順に指定した家事IDを追加する。
     *
     * @param mixed $housework
     * @return void
     */
    public static function attachHouseworkOrder($housework): void
    {
        $user = Auth::user();
        // すでに家事の表示順が設定されているかどうかを確認する
        $houseworkOrder = HouseworkOrder::where('user_id', $user->id)->firstOr(function () {
            return null;
        });
        // 設定されていなければ新規登録し、設定されていれば更新する
        if (empty($houseworkOrder)) {
            $houseworkOrder = HouseworkOrder::create([
                'user_id' => $user->id,
                'order' => $housework->id,
            ]);
        } else {
            $houseworkOrder->order = $houseworkOrder->order . ',' . (string) $housework->id;
            $houseworkOrder->save();
        }
    }
}
