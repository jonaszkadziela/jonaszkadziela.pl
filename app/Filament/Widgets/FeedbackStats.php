<?php

namespace App\Filament\Widgets;

use App\Models\Feedback;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\HtmlString;

class FeedbackStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(
                Lang::get('admin.feedbacks.stats.feedback-count'),
                Feedback::count(),
            )
            ->description(Lang::get('admin.feedbacks.stats.feedback-count-description'))
            ->icon('heroicon-o-chat-bubble-oval-left-ellipsis'),
            Stat::make(
                Lang::get('admin.feedbacks.stats.recent-feedback'),
                Feedback::whereBetween('created_at', [Carbon::now()->subHours(24), Carbon::now()])->count(),
            )
            ->description(Lang::get('admin.feedbacks.stats.recent-feedback-description'))
            ->icon('heroicon-o-clock'),
            Stat::make(
                Lang::get('admin.feedbacks.stats.breakdown-by-type'),
                new HtmlString(
                    '<div class="flex flex-wrap font-normal gap-x-6 text-sm">' .
                        Feedback::groupBy('type')
                            ->selectRaw('COUNT(*) as count, type')
                            ->get()
                            ->map(
                                fn (Feedback $feedback) => '<div class="flex gap-2 items-center">' .
                                    '<p class="dark:text-gray-400 text-gray-500">' . Lang::get('admin.feedbacks.types.' . $feedback->type) . '</p>' .
                                    '<p class="font-semibold text-3xl">' . $feedback->count . '</p>' .
                                    '</div>'
                            )
                            ->join(' ') .
                    '</div>'
                ),
            )
            ->description(Lang::get('admin.feedbacks.stats.breakdown-by-type-description'))
            ->icon('heroicon-o-queue-list'),
        ];
    }
}
