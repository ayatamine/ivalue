<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('عدد التقارير المنتهية ',2)
            ->icon('icon-document_complete')
            ->description('عدد التقارير المنتهية ')
            ->descriptionColor('success')
            ->color('success')
            ->extraAttributes(['new-card-design'=>true,'green-card'=>true]),
            Stat::make('تقرير مازالت تحت المراجعة ', 5)
                ->icon('icon-document_reviews')
                ->description('تقرير مازالت تحت المراجعة ')
                ->descriptionColor('primary')
                ->extraAttributes(['new-card-design'=>true,'primary-card'=>true]),
            Stat::make('تقارير تم رفضها', 1)
                 ->icon('icon-document_canceled')
                 ->description('تقارير تم رفضها')
                 ->descriptionColor('danger')
                 ->extraAttributes(['new-card-design'=>true,'danger-card'=>true]),
            Stat::make('تقارير لم يتم الاطلاع عليها', 1)
                ->icon('icon-document_uploaded')
                ->description('تقارير لم يتم الاطلاع عليها')
                ->descriptionColor('warning')
                ->extraAttributes(['new-card-design'=>true,'warning-card'=>true])
        ];
    }
}
