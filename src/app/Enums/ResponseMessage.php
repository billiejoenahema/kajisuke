<?php

declare(strict_types=1);

namespace App\Enums;

enum ResponseMessage: string
{
    case ARCHIVE_CERATED = '新しい履歴を登録しました';
    case ARCHIVE_UPDATED = '履歴を更新しました';
    case ARCHIVE_DELETED = '履歴を削除しました';
    case CATEGORY_CERATED = '新しいカテゴリを登録しました';
    case CATEGORY_UPDATED = 'カテゴリを更新しました';
    case CATEGORY_DELETED = 'カテゴリを削除しました';
    case CATEGORY_HAS_HOUSEWORK = 'このカテゴリは使用されているため削除できません';
    case HOUSEWORK_CERATED = '新しい家事を登録しました';
    case HOUSEWORK_UPDATED = '家事を更新しました';
    case HOUSEWORK_DELETED = '家事を削除しました';
    case PROFILE_UPDATED = 'プロフィールを更新しました';
    case PROFILE_NO_IMAGE = '画像が存在しません';
}
