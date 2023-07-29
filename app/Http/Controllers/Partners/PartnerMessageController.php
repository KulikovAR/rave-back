<?php

namespace App\Http\Controllers\Partners;

use App\Http\Controllers\Controller;
use App\Http\Requests\Partners\PartnerMessageRequest;
use App\Http\Responses\ApiJsonResponse;
use App\Models\TakeOut;
use App\Services\NotificationService;

class PartnerMessageController extends Controller
{
    public function store(PartnerMessageRequest $request)
    {
        $user = $request->user();

        $this->savePartnerRequestMessage($request);
        $this->setUserTakeoutMethod($request);

        NotificationService::notifyAdmin(__('partners.partner_request'));

        return new ApiJsonResponse(message: __('partners.message_sent'));
    }


    private function savePartnerRequestMessage(PartnerMessageRequest $request): void
    {
        $request->user()->partnerMessage()
                ->create(['link_location' => $request->partner_url_location]);

    }


    private function setUserTakeoutMethod(PartnerMessageRequest $request): void
    {
        $requestData = $request->validated();
        $user        = $request->user();

        if ($request->take_out_type === TakeOut::TAKEOUT_BANK) {
            $user->partner_takeout = TakeOut::TAKEOUT_BANK;
            $user->save();

            $user->banks()->create($requestData);
            return;
        }

        $user->partner_takeout = TakeOut::TAKEOUT_CARD;
        $user->save();

        $user->creditCards()->create($requestData);
    }
}
