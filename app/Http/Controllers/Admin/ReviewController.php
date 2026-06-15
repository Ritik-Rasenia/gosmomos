<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\BlogReview;

class ReviewController extends Controller
{
    /**
     * Product Reviews List
     */
    public function productIndex()
    {
        $reviews = Review::with(['user', 'product'])->latest()->get();
        return view('admin.reviews.product', compact('reviews'));
    }

    /**
     * Toggle approval status for Product Review
     */
    public function productToggleApprove($id)
    {
        $review = Review::findOrFail($id);
        $review->is_approved = !$review->is_approved;
        $review->save();

        $status = $review->is_approved ? 'approved' : 'disapproved';
        return back()->with('success', "Product review has been {$status} successfully!");
    }

    /**
     * Add or Update Admin Reply for Product Review
     */
    public function productReply(Request $request, $id)
    {
        $request->validate([
            'admin_reply' => 'nullable|string|max:1000',
        ]);

        $review = Review::findOrFail($id);
        $review->admin_reply = $request->admin_reply;
        $review->save();

        return back()->with('success', 'Admin reply updated successfully!');
    }

    /**
     * Delete Product Review
     */
    public function productDestroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return back()->with('success', 'Product review deleted successfully!');
    }

    /**
     * Blog Reviews List
     */
    public function blogIndex()
    {
        $reviews = BlogReview::with(['user', 'blog'])->latest()->get();
        return view('admin.reviews.blog', compact('reviews'));
    }

    /**
     * Toggle approval status for Blog Review
     */
    public function blogToggleApprove($id)
    {
        $review = BlogReview::findOrFail($id);
        $review->is_approved = !$review->is_approved;
        $review->save();

        $status = $review->is_approved ? 'approved' : 'disapproved';
        return back()->with('success', "Blog review has been {$status} successfully!");
    }

    /**
     * Add or Update Admin Reply for Blog Review
     */
    public function blogReply(Request $request, $id)
    {
        $request->validate([
            'admin_reply' => 'nullable|string|max:1000',
        ]);

        $review = BlogReview::findOrFail($id);
        $review->admin_reply = $request->admin_reply;
        $review->save();

        return back()->with('success', 'Admin reply updated successfully!');
    }

    /**
     * Delete Blog Review
     */
    public function blogDestroy($id)
    {
        $review = BlogReview::findOrFail($id);
        $review->delete();

        return back()->with('success', 'Blog review deleted successfully!');
    }
}
