<?php

namespace App\Services;

use App\Models\Housework;
use App\Models\HouseworkOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HouseworkService
{
    /**
     * 次回実施日を返す。
     *
     * @param String $cycle
     * @param DateTime $last_date
     * @return String
     */
    public static function getNextDate($cycle, $last_date): String
    {
        $next_date = date('Y年m月d日', strtotime($last_date . $cycle));
        return $next_date;
    }

    /**
     * 実行周期を判読可能な文字列に変換して返す。
     *
     * @param String $cycle
     * @return String
     */
    public static function getCycleValue($cycle): String
    {
        $explodedCycles = [];
        // $cycleをスペースを区切り文字で分割する。
        $explodedCycles = explode(' ', $cycle);
        $cycleNum = str_replace('+', '', $explodedCycles[0]);
        $cycleUnit = $explodedCycles[1];
        if ($cycleUnit == 'day') {
            $cycle_value = $cycleNum == '1' ? '毎日' : $cycleNum . '日に一度';
        } elseif ($cycleUnit == 'week') {
            $cycle_value = $cycleNum == '1' ? '毎週' : $cycleNum . '週に一度';
        } elseif ($cycleUnit == 'month') {
            $cycle_value = $cycleNum == '1' ? '毎月' : $cycleNum . 'ヶ月に一度';
        } elseif ($cycleUnit == 'year') {
            $cycle_value = $cycleNum == '1' ? '毎年' : $cycleNum . '年に一度';
        }
        return $cycle_value;
    }

    /**
     * 家事を新規登録する。
     *
     * @param StoreHouseworkRequest $request
     * @return Housework
     */
    public static function store($request): Housework
    {
        $housework = DB::transaction(function () use ($request) {
            // 家事を新規登録する
            $housework = Housework::create([
                'user_id' => Auth::user()->id,
                'title' => $request['title'],
                'comment' => $request['comment'],
                'cycle' => $request->getCycle(),
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
            $housework->cycle = $request->getCycle();
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
