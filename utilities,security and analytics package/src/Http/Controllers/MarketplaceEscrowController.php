<?php

namespace ProNetworkUtilitiesSecurityAnalytics\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use ProNetwork\Models\MarketplaceEscrow;
use ProNetwork\Services\MarketplaceEscrowDomain;
use ProNetworkUtilitiesSecurityAnalytics\Http\Requests\OpenEscrowRequest;
use ProNetworkUtilitiesSecurityAnalytics\Http\Requests\RefundEscrowRequest;
use ProNetworkUtilitiesSecurityAnalytics\Http\Requests\ReleaseEscrowRequest;

class MarketplaceEscrowController extends Controller
{
    public function __construct(protected MarketplaceEscrowDomain $escrowService)
    {
    }

    public function showByOrder(Request $request, int $orderId)
    {
        $escrow = MarketplaceEscrow::with(['milestones', 'transactions', 'disputes.messages'])
            ->where('order_id', $orderId)
            ->firstOrFail();

        if ($request->expectsJson()) {
            return response()->json([
                'escrow' => $escrow,
            ]);
        }

        return view('pro_network::escrow.show', [
            'escrow' => $escrow,
        ]);
    }

    public function open(OpenEscrowRequest $request, int $orderId)
    {
        $data = $request->validated();

        $escrow = $this->escrowService->open(
            $orderId,
            (float) $data['amount'],
            $data['currency'] ?? 'USD',
            $data['delivery_method'] ?? 'delivery'
        );

        if (! empty($data['delivery_notes'])) {
            $escrow->delivery_notes = $data['delivery_notes'];
            $escrow->save();
        }

        if ($request->expectsJson()) {
            return response()->json([
                'escrow' => $escrow->fresh(),
                'message' => 'Escrow opened successfully.',
            ]);
        }

        return view('pro_network::escrow.show', [
            'escrow' => $escrow->fresh(),
        ]);
    }

    public function release(ReleaseEscrowRequest $request, int $escrowId)
    {
        $data = $request->validated();
        $escrow = MarketplaceEscrow::findOrFail($escrowId);

        $transaction = $this->escrowService->release($escrow, (float) $data['amount']);
        $transaction->user_id = $request->user()->id;
        $transaction->save();
        $escrow->refresh();

        if ($request->expectsJson()) {
            return response()->json([
                'escrow' => $escrow,
                'transaction' => $transaction,
                'message' => 'Escrow released.',
            ]);
        }

        return view('pro_network::escrow.show', [
            'escrow' => $escrow,
            'transaction' => $transaction,
        ]);
    }

    public function refund(RefundEscrowRequest $request, int $escrowId)
    {
        $data = $request->validated();
        $escrow = MarketplaceEscrow::findOrFail($escrowId);

        $transaction = $this->escrowService->refund($escrow, (float) $data['amount']);
        $transaction->user_id = $request->user()->id;
        if (! empty($data['reason'])) {
            $transaction->notes = $data['reason'];
        }
        $transaction->save();
        $escrow->refresh();

        if ($request->expectsJson()) {
            return response()->json([
                'escrow' => $escrow,
                'transaction' => $transaction,
                'message' => 'Escrow refunded.',
            ]);
        }

        return view('pro_network::escrow.show', [
            'escrow' => $escrow,
            'transaction' => $transaction,
        ]);
    }
}
