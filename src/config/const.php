<?php

return [
    'ARCHIVE' => [
        'CREATED' => ['message' => '新しい履歴を登録しました'],
        'UPDATED' => ['message' => '履歴を更新しました'],
        'DELETED' => ['message' => '履歴を削除しました'],
    ],
    'CATEGORY' => [
        'CREATED' => ['message' => '新しいカテゴリを登録しました'],
        'UPDATED' => ['message' => 'カテゴリを更新しました'],
        'DELETED' => ['message' => 'カテゴリを削除しました'],
        'HAS_HOUSEWORK' => ['message' => 'このカテゴリは使用されているため削除できません'],
    ],
    'HOUSEWORK' => [
        'CREATED' => ['message' => '新しい家事を登録しました'],
        'UPDATED' => ['message' => '家事を更新しました'],
        'DELETED' => ['message' => '家事を削除しました'],
    ],
    'PROFILE' => [
        'UPDATED' => ['message' => 'プロフィールを更新しました'],
    ],
    'GENDER_VALUES' => [
        ['id' => 0, 'value' => '未選択'],
        ['id' => 1, 'value' => '男性'],
        ['id' => 2, 'value' => '女性'],
        ['id' => 9, 'value' => '適用不能'],
    ],
    'PREFECTURES' => [
        [1 => '北海道'],
        [2 => '青森県'],
        [3 => '岩手県'],
        [4 => '宮城県'],
        [5 => '秋田県'],
        [6 => '山形県'],
        [7 => '福島県'],
        [8 => '茨城県'],
        [9 => '栃木県'],
        [10 => '群馬県'],
        [11 => '埼玉県'],
        [12 => '千葉県'],
        [13 => '東京都'],
        [14 => '神奈川県'],
        [15 => '新潟県'],
        [16 => '富山県'],
        [17 => '石川県'],
        [18 => '福井県'],
        [19 => '山梨県'],
        [20 => '長野県'],
        [21 => '岐阜県'],
        [22 => '静岡県'],
        [23 => '愛知県'],
        [24 => '三重県'],
        [25 => '滋賀県'],
        [26 => '京都府'],
        [27 => '大阪府'],
        [28 => '兵庫県'],
        [29 => '奈良県'],
        [30 => '和歌山県'],
        [31 => '鳥取県'],
        [32 => '島根県'],
        [33 => '岡山県'],
        [34 => '広島県'],
        [35 => '山口県'],
        [36 => '徳島県'],
        [37 => '香川県'],
        [38 => '愛媛県'],
        [39 => '高知県'],
        [40 => '福岡県'],
        [41 => '佐賀県'],
        [42 => '長崎県'],
        [43 => '熊本県'],
        [44 => '大分県'],
        [45 => '宮崎県'],
        [46 => '鹿児島県'],
        [47 => '沖縄県'],
    ],
    'YEARS' => range(1940, date('Y')),
    'MONTHS' => toTwoDigitZeroPaddingArray(range(1, 12)),
    'DAYS' => toTwoDigitZeroPaddingArray(range(1, 31)),
    'MAX_LENGTHS' => [
        ['housework_title' => 30],
        ['housework_comment' => 200],
        ['category_name' => 30],
        ['archive_content' => 200],
    ]
];

/**
 * 整数の配列を2桁の0埋め文字列の配列で返す。
 *
 * @param array $array
 * @return array
 */
function toTwoDigitZeroPaddingArray($array): array
{
    foreach($array as $index => $value) {
        $array[$index] = str_pad($value, 2, '0', STR_PAD_LEFT);
    }
    return $array;
}
