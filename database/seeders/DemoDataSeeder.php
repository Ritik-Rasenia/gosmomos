<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\EventLead;
use App\Models\FranchiseLead;
use App\Models\User;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();
        if (!$admin) return;

        // ─── Notifications ────────────────────────────────────────────────────────
        $notifData = [
            ['type'=>'order',     'title'=>'New Order Received #ORD-1042', 'message'=>'Rahul Sharma placed an order for 2x Chicken Momo, 1x Veg Momo. Total: ₹280. Payment: UPI.', 'read_at'=>null, 'data'=>['order_id'=>1042,'total'=>280,'items'=>3]],
            ['type'=>'franchise', 'title'=>'New Franchise Application', 'message'=>'Priya Mehta from Jaipur, Rajasthan has applied for a Kiosk franchise. Investment budget: ₹10–15 Lakh.', 'read_at'=>null, 'data'=>['city'=>'Jaipur','type'=>'kiosk']],
            ['type'=>'catering',  'title'=>'Catering Inquiry Received', 'message'=>'Arun Kumar is requesting catering for a corporate event on 20 July 2025 for 200 guests in Gurgaon.', 'read_at'=>null, 'data'=>['event_type'=>'corporate','guests'=>200,'city'=>'Gurgaon']],
            ['type'=>'booking',   'title'=>'Table Booking Request — 4 Guests', 'message'=>'Sneha Patel has requested a table for 4 on 15 June 2025 at 7:30 PM. Contact: 9876543210.', 'read_at'=>null, 'data'=>['guests'=>4,'date'=>'15 Jun 2025','time'=>'7:30 PM']],
            ['type'=>'order',     'title'=>'Order Delivered Successfully #ORD-1038', 'message'=>'Order for Kavya Reddy has been marked as delivered by delivery partner Ramesh. Total: ₹420.', 'read_at'=>now()->subHours(2), 'data'=>['order_id'=>1038,'total'=>420]],
            ['type'=>'system',    'title'=>'Daily Revenue Report — ₹28,450', 'message'=>'Today\'s total revenue is ₹28,450 across 94 orders. Best selling item: Chicken Momo (42 orders).', 'read_at'=>now()->subHours(5), 'data'=>['revenue'=>28450,'orders'=>94]],
            ['type'=>'franchise', 'title'=>'Franchise Lead: Site Visit Scheduled', 'message'=>'Arjun Rao\'s franchise site visit is confirmed for 18 June 2025 at the Koramangala outlet, Bangalore.', 'read_at'=>null, 'data'=>['city'=>'Bangalore','applicant'=>'Arjun Rao']],
            ['type'=>'alert',     'title'=>'Low Stock Alert: Chicken Filling', 'message'=>'Chicken momo filling stock is below threshold at the Noida outlet. Current stock: 2.3 kg. Reorder recommended.', 'read_at'=>null, 'data'=>['outlet'=>'Noida','product'=>'Chicken Filling','stock'=>'2.3 kg']],
            ['type'=>'blog',      'title'=>'Blog Post Published', 'message'=>'\"The Secret Behind Perfect Steamed Momos\" has been published and is live on the website.', 'read_at'=>now()->subDays(1), 'data'=>['post_title'=>'The Secret Behind Perfect Steamed Momos']],
            ['type'=>'catering',  'title'=>'Catering Booking Confirmed — Wedding', 'message'=>'Meera Joshi\'s wedding catering for 350 guests on 25 July in Delhi has been confirmed. ₹1,75,000.', 'read_at'=>now()->subDays(2), 'data'=>['event_type'=>'wedding','guests'=>350,'amount'=>175000]],
            ['type'=>'order',     'title'=>'Bulk Order Alert — ₹3,200', 'message'=>'TechCorp Solutions has placed a bulk office order for 85 momos across 5 variants. Prep time: 45 mins.', 'read_at'=>null, 'data'=>['order_type'=>'bulk','total'=>3200,'items'=>85]],
            ['type'=>'system',    'title'=>'New Customer Registered', 'message'=>'Vikram Nair has registered via the mobile app. 5th registration today.', 'read_at'=>now()->subHours(8), 'data'=>['name'=>'Vikram Nair','method'=>'app']],
        ];

        foreach ($notifData as $n) {
            Notification::firstOrCreate(
                ['user_id' => $admin->id, 'title' => $n['title']],
                [
                    'user_id' => $admin->id,
                    'type'    => $n['type'],
                    'title'   => $n['title'],
                    'message' => $n['message'],
                    'data'    => $n['data'],
                    'read_at' => $n['read_at'],
                ]
            );
        }

        // ─── Book a Table / Catering Event Leads ────────────────────────────────
        $eventLeads = [
            ['name'=>'Rahul Mehra',      'email'=>'rahul.mehra@gmail.com',    'phone'=>'9812345670', 'event_type'=>'birthday',    'event_date'=>now()->addDays(15)->format('Y-m-d'), 'guest_count'=>50,  'budget'=>12000,  'city'=>'Delhi',     'message'=>'Looking for live momo station for my daughter\'s 5th birthday party. Need veg options only.', 'status'=>'new'],
            ['name'=>'Priya Singh',       'email'=>'priya.singh@techsol.com',  'phone'=>'9901234567', 'event_type'=>'corporate',   'event_date'=>now()->addDays(8)->format('Y-m-d'),  'guest_count'=>120, 'budget'=>35000,  'city'=>'Gurgaon',   'message'=>'Annual team lunch for our 120-person office. Need setup and serving staff included.', 'status'=>'contacted'],
            ['name'=>'Arun Kumar',        'email'=>'arunfamily22@yahoo.com',   'phone'=>'9756012345', 'event_type'=>'wedding',     'event_date'=>now()->addDays(30)->format('Y-m-d'), 'guest_count'=>350, 'budget'=>175000, 'city'=>'Delhi',     'message'=>'Reception dinner, expecting 350 guests. Want live counter with chicken and paneer options.', 'status'=>'booked'],
            ['name'=>'Sneha Patel',       'email'=>'sneha.p@outlook.com',      'phone'=>'9632147850', 'event_type'=>'college_fest','event_date'=>now()->addDays(20)->format('Y-m-d'), 'guest_count'=>600, 'budget'=>45000,  'city'=>'Pune',      'message'=>'Annual college cultural fest. Need 2 momo counters. Budget flexible for good quality.', 'status'=>'new'],
            ['name'=>'Vikram Nair',       'email'=>'v.nair.events@gmail.com',  'phone'=>'9811234567', 'event_type'=>'bulk_order',  'event_date'=>now()->addDays(3)->format('Y-m-d'),  'guest_count'=>80,  'budget'=>22000,  'city'=>'Bangalore', 'message'=>'Recurring weekly office lunch order. Want to set up a monthly contract.', 'status'=>'contacted'],
            ['name'=>'Meera Joshi',       'email'=>'meeraj@entrepreneur.in',   'phone'=>'9701234567', 'event_type'=>'birthday',    'event_date'=>now()->addDays(12)->format('Y-m-d'), 'guest_count'=>25,  'budget'=>8000,   'city'=>'Mumbai',    'message'=>'Small intimate birthday dinner. Adults only. Premium menu preferred.', 'status'=>'new'],
            ['name'=>'Deepak Verma',      'email'=>'deepak.v@infosys.com',     'phone'=>'9551234567', 'event_type'=>'corporate',   'event_date'=>now()->addDays(45)->format('Y-m-d'), 'guest_count'=>200, 'budget'=>60000,  'city'=>'Hyderabad', 'message'=>'Quarterly all-hands meeting catering. Vegetarian preferred as we have many team members with dietary restrictions.', 'status'=>'new'],
        ];

        foreach ($eventLeads as $lead) {
            EventLead::firstOrCreate(
                ['email' => $lead['email'], 'event_type' => $lead['event_type']],
                $lead
            );
        }

        // ─── Franchise Leads ─────────────────────────────────────────────────────
        $franchiseLeads = [
            ['name'=>'Arjun Rao',         'email'=>'arjun.rao@gmail.com',     'phone'=>'9801234567', 'city'=>'Bangalore',   'state'=>'Karnataka',       'investment_budget'=>'₹18–25 Lakh', 'franchise_type'=>'cafe',    'experience'=>'5 years in restaurant management', 'message'=>'I run a small café and want to expand with a proven brand. GOS MOMO is my first choice.', 'status'=>'site_visit', 'follow_up_date'=>now()->addDays(7)->format('Y-m-d')],
            ['name'=>'Sunita Agarwal',    'email'=>'sunita.a@hotmail.com',    'phone'=>'9911234567', 'city'=>'Jaipur',      'state'=>'Rajasthan',       'investment_budget'=>'₹8–12 Lakh',  'franchise_type'=>'kiosk',   'experience'=>'No F&B experience, but strong business background', 'message'=>'Looking for a low-risk food business. Interested in the kiosk model at a mall near me.', 'status'=>'contacted', 'follow_up_date'=>now()->addDays(3)->format('Y-m-d')],
            ['name'=>'Mohammed Yusuf',    'email'=>'m.yusuf.biz@gmail.com',   'phone'=>'9712345678', 'city'=>'Hyderabad',   'state'=>'Telangana',       'investment_budget'=>'₹10–15 Lakh', 'franchise_type'=>'kiosk',   'experience'=>'Textile business owner, first food venture', 'message'=>'I have been following GOS MOMO for 2 years. Ready to invest. Please send the franchise kit.', 'status'=>'approved', 'follow_up_date'=>null],
            ['name'=>'Kavitha Sharma',    'email'=>'kavithas@corporatespace.co','phone'=>'9821234567','city'=>'Chennai',     'state'=>'Tamil Nadu',      'investment_budget'=>'₹45+ Lakh',   'franchise_type'=>'master',  'experience'=>'Entrepreneur with 3 QSR outlets in Chennai', 'message'=>'Looking to acquire master franchise rights for Tamil Nadu. Have capital and existing infrastructure.', 'status'=>'contacted', 'follow_up_date'=>now()->addDays(10)->format('Y-m-d')],
            ['name'=>'Rohit Bansal',      'email'=>'rohit.bansal@startups.in', 'phone'=>'9631234567', 'city'=>'Lucknow',     'state'=>'Uttar Pradesh',   'investment_budget'=>'₹8–12 Lakh',  'franchise_type'=>'kiosk',   'experience'=>'First-time business owner', 'message'=>'Lucknow has huge appetite for momos. I want to be the first GOS MOMO franchisee here.', 'status'=>'new', 'follow_up_date'=>null],
            ['name'=>'Aisha Khan',        'email'=>'aisha.k.ventures@gmail.com','phone'=>'9541234567','city'=>'Kolkata',     'state'=>'West Bengal',     'investment_budget'=>'₹18–25 Lakh', 'franchise_type'=>'cafe',    'experience'=>'Interior designer turned entrepreneur', 'message'=>'I want to create a premium momo café experience in Kolkata. The city loves momos.', 'status'=>'new', 'follow_up_date'=>null],
            ['name'=>'Rajesh Gupta',      'email'=>'rajesh.g.food@yahoo.com',  'phone'=>'9451234567', 'city'=>'Ahmedabad',   'state'=>'Gujarat',         'investment_budget'=>'₹10–15 Lakh', 'franchise_type'=>'kiosk',   'experience'=>'Retired bank manager with savings to invest', 'message'=>'Looking for passive income with a reputable brand. Want to understand the hiring model.', 'status'=>'rejected', 'follow_up_date'=>null],
        ];

        foreach ($franchiseLeads as $lead) {
            FranchiseLead::firstOrCreate(
                ['email' => $lead['email']],
                $lead
            );
        }
    }
}
