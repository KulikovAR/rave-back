<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Notifications\Action;
use Illuminate\Notifications\Notification;

class BaseNotification extends Notification implements ShouldQueue, ShouldBeEncrypted
{
    use Queueable;

    protected function makeActionIntoLine(Action $action): Htmlable {
        return new class($action) implements Htmlable {
            private $action;

            public function __construct(Action $action) {
                $this->action = $action;
            }

            public function toHtml() {
                return $this->strip($this->table());
            }

            private function table() {
                return sprintf(
                    '%s', $this->btn());
            }

            private function btn() {
                return sprintf(
                    '<a
                        href="%s"
                        target="_blank"
                    >%s</a>',
                    htmlspecialchars($this->action->url),
                    htmlspecialchars($this->action->text)
                );
            }

            private function strip($text) {
                return str_replace("\n", ' ', $text);
            }

        };
    }
}
