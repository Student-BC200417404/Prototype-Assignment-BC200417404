<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use App\Models\FaqCategory;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DialogflowExportController extends Controller
{
    /**
     * Export menu categories for Dialogflow
     * Only exports name and snonym (no description)
     */
    public function exportMenuCategories()
    {
        $categories = Category::where('is_active', true)->get();
        // Only name is used as both reference and synonym
        $csvContent = '';
        foreach ($categories as $category) {
            $csvContent .= '"' . $category->name . '", "' . $category->name . '"' . "\n";
        }
        return $this->downloadCsv($csvContent, 'menu-category.csv');
    }

    /**
     * Export menu items for Dialogflow
     * Only exports name and snonym (no description)
     */
    public function exportMenuItems()
    {
        $menuItems = Menu::where('is_available', true)->get();
        // Only name is used as both reference and synonym
        $csvContent = '';
        foreach ($menuItems as $item) {
            $csvContent .= '"' . $item->name . '", "' . $item->name . '"' . "\n";
        }
        return $this->downloadCsv($csvContent, 'item.csv');
    }

    /**
     * Export FAQ topics for Dialogflow
     * Only exports name (no description or synonyms)
     */
    public function exportFaqTopics()
    {
        $faqCategories = FaqCategory::where('is_active', true)->get();
        // Only name is used
        $csvContent = $this->generateCsvContent($faqCategories, 'name');
        return $this->downloadCsv($csvContent, 'faq-topic.csv');
    }

    /**
     * Export quantity entities for Dialogflow
     */
    public function exportQuantities()
    {
        $quantities = [
            ['name' => 'one', 'snonym' => '1, single, one piece'],
            ['name' => 'two', 'snonym' => '2, couple, pair, duo'],
            ['name' => 'three', 'snonym' => '3, trio, triple'],
            ['name' => 'four', 'snonym' => '4, quartet'],
            ['name' => 'five', 'snonym' => '5, quintet'],
            ['name' => 'six', 'snonym' => '6, half dozen'],
            ['name' => 'seven', 'snonym' => '7'],
            ['name' => 'eight', 'snonym' => '8'],
            ['name' => 'nine', 'snonym' => '9'],
            ['name' => 'ten', 'snonym' => '10, dozen'],
            ['name' => 'dozen', 'snonym' => '12, twelve'],
            ['name' => 'half dozen', 'snonym' => '6, six'],
        ];
        
        $csvContent = $this->generateCsvFromArray($quantities, 'name', 'snonym');
        
        return $this->downloadCsv($csvContent, 'quantity.csv');
    }

    /**
     * Export status types for Dialogflow
     */
    public function exportStatusTypes()
    {
        $statusTypes = [
            ['name' => 'tracking', 'snonym' => 'track, follow, monitor, check status'],
            ['name' => 'status', 'snonym' => 'state, condition, progress, update'],
            ['name' => 'progress', 'snonym' => 'advancement, development, stage'],
            ['name' => 'pending', 'snonym' => 'waiting, in queue, not started'],
            ['name' => 'preparing', 'snonym' => 'cooking, making, in progress'],
            ['name' => 'ready', 'snonym' => 'completed, finished, done, available'],
            ['name' => 'delivered', 'snonym' => 'sent, completed, finished'],
            ['name' => 'cancelled', 'snonym' => 'canceled, stopped, terminated'],
        ];
        
        $csvContent = $this->generateCsvFromArray($statusTypes, 'name', 'snonym');
        
        return $this->downloadCsv($csvContent, 'status-type.csv');
    }

    /**
     * Export datetime entities for Dialogflow
     */
    public function exportDateTime()
    {
        $dateTimeEntities = [
            ['name' => 'tomorrow', 'snonym' => 'next day, day after today'],
            ['name' => 'today', 'snonym' => 'this day, now, current day'],
            ['name' => 'yesterday', 'snonym' => 'day before today, previous day'],
            ['name' => 'next week', 'snonym' => 'following week, upcoming week'],
            ['name' => 'this week', 'snonym' => 'current week, present week'],
            ['name' => 'next month', 'snonym' => 'following month, upcoming month'],
            ['name' => 'this month', 'snonym' => 'current month, present month'],
            ['name' => 'next year', 'snonym' => 'following year, upcoming year'],
            ['name' => 'this year', 'snonym' => 'current year, present year'],
            ['name' => 'morning', 'snonym' => 'AM, before noon, early day'],
            ['name' => 'afternoon', 'snonym' => 'PM, midday, early evening'],
            ['name' => 'evening', 'snonym' => 'night, PM, late day'],
            ['name' => 'night', 'snonym' => 'evening, late, PM'],
            ['name' => 'lunch', 'snonym' => 'noon, midday, 12 PM'],
            ['name' => 'dinner', 'snonym' => 'evening meal, supper, night meal'],
            ['name' => 'breakfast', 'snonym' => 'morning meal, AM meal'],
        ];
        
        $csvContent = $this->generateCsvFromArray($dateTimeEntities, 'name', 'snonym');
        
        return $this->downloadCsv($csvContent, 'datetime.csv');
    }

    /**
     * Export party size entities for Dialogflow
     */
    public function exportPartySize()
    {
        $partySizes = [
            ['name' => '1 person', 'snonym' => 'one person, single, solo, individual'],
            ['name' => '2 people', 'snonym' => 'two people, couple, pair, duo'],
            ['name' => '3 people', 'snonym' => 'three people, trio, group of three'],
            ['name' => '4 people', 'snonym' => 'four people, quartet, group of four'],
            ['name' => '5 people', 'snonym' => 'five people, group of five'],
            ['name' => '6 people', 'snonym' => 'six people, group of six, half dozen'],
            ['name' => '7 people', 'snonym' => 'seven people, group of seven'],
            ['name' => '8 people', 'snonym' => 'eight people, group of eight'],
            ['name' => '9 people', 'snonym' => 'nine people, group of nine'],
            ['name' => '10 people', 'snonym' => 'ten people, group of ten'],
            ['name' => 'large group', 'snonym' => 'big group, many people, crowd'],
            ['name' => 'small group', 'snonym' => 'few people, intimate group'],
        ];
        
        $csvContent = $this->generateCsvFromArray($partySizes, 'name', 'snonym');
        
        return $this->downloadCsv($csvContent, 'party-size.csv');
    }

    /**
     * Export name entities for Dialogflow
     */
    public function exportNames()
    {
        $customers = Customer::whereNotNull('first_name')
            ->whereNotNull('last_name')
            ->get();
        
        $names = [];
        foreach ($customers as $customer) {
            $names[] = [
                'name' => $customer->first_name,
                'snonym' => $customer->first_name . ' ' . $customer->last_name . ', ' . $customer->first_name
            ];
        }
        
        // Add some common names if we don't have many customers
        if (count($names) < 10) {
            $commonNames = [
                ['name' => 'John', 'snonym' => 'John, Johnny, Jon'],
                ['name' => 'Jane', 'snonym' => 'Jane, Janie'],
                ['name' => 'Mike', 'snonym' => 'Mike, Michael, Mikey'],
                ['name' => 'Sarah', 'snonym' => 'Sarah, Sara'],
                ['name' => 'David', 'snonym' => 'David, Dave, Davy'],
                ['name' => 'Lisa', 'snonym' => 'Lisa, Liza'],
                ['name' => 'Tom', 'snonym' => 'Tom, Tommy, Thomas'],
                ['name' => 'Mary', 'snonym' => 'Mary, Maria'],
                ['name' => 'Bob', 'snonym' => 'Bob, Bobby, Robert'],
                ['name' => 'Anna', 'snonym' => 'Anna, Anne, Annie'],
            ];
            $names = array_merge($names, $commonNames);
        }
        
        $csvContent = $this->generateCsvFromArray($names, 'name', 'snonym');
        
        return $this->downloadCsv($csvContent, 'name.csv');
    }

    /**
     * Export email entities for Dialogflow
     */
    public function exportEmails()
    {
        $customers = Customer::whereNotNull('email')->get();
        
        $emails = [];
        foreach ($customers as $customer) {
            $emails[] = [
                'name' => $customer->email,
                'snonym' => $customer->email . ', email address, contact email'
            ];
        }
        
        // Add some example email patterns if we don't have many customers
        if (count($emails) < 5) {
            $exampleEmails = [
                ['name' => 'example@email.com', 'snonym' => 'example@email.com, email address, contact email'],
                ['name' => 'user@domain.com', 'snonym' => 'user@domain.com, email address, contact email'],
                ['name' => 'contact@restaurant.com', 'snonym' => 'contact@restaurant.com, email address, contact email'],
            ];
            $emails = array_merge($emails, $exampleEmails);
        }
        
        $csvContent = $this->generateCsvFromArray($emails, 'name', 'snonym');
        
        return $this->downloadCsv($csvContent, 'email.csv');
    }

    /**
     * Export phone entities for Dialogflow
     */
    public function exportPhones()
    {
        $customers = Customer::whereNotNull('phone')->get();
        
        $phones = [];
        foreach ($customers as $customer) {
            $phones[] = [
                'name' => $customer->phone,
                'snonym' => $customer->phone . ', phone number, contact number, mobile'
            ];
        }
        
        // Add some example phone patterns if we don't have many customers
        if (count($phones) < 5) {
            $examplePhones = [
                ['name' => '+1-555-0101', 'snonym' => '+1-555-0101, phone number, contact number, mobile'],
                ['name' => '+1-555-0102', 'snonym' => '+1-555-0102, phone number, contact number, mobile'],
                ['name' => '+1-555-0103', 'snonym' => '+1-555-0103, phone number, contact number, mobile'],
            ];
            $phones = array_merge($phones, $examplePhones);
        }
        
        $csvContent = $this->generateCsvFromArray($phones, 'name', 'snonym');
        
        return $this->downloadCsv($csvContent, 'phone.csv');
    }

    /**
     * Export all entities as a zip file
     */
    public function exportAll()
    {
        $stats = [
            'categories' => \App\Models\Category::where('is_active', true)->count(),
            'menu_items' => \App\Models\Menu::where('is_available', true)->count(),
            'faq_topics' => \App\Models\FaqCategory::where('is_active', true)->count(),
            'customer_names' => \App\Models\Customer::whereNotNull('first_name')->count(),
            'emails' => \App\Models\Customer::whereNotNull('email')->count(),
            'phones' => \App\Models\Customer::whereNotNull('phone')->count(),
        ];
        return view('admin.pages.dialogflow.export', compact('stats'));
    }

    /**
     * Generate CSV content from Eloquent models
     */
    private function generateCsvContent($models, $nameField, $synonymField = null)
    {
        $csvContent = '';
        
        foreach ($models as $model) {
            $referenceValue = $model->$nameField;
            $synonyms = '';
            
            if ($synonymField && $model->$synonymField) {
                $synonyms = ', ' . $model->$synonymField;
            }
            
            // Include the reference value twice if you want it to be matched by the entity
            $csvContent .= '"' . $referenceValue . '", "' . $referenceValue . $synonyms . '"' . "\n";
        }
        
        return $csvContent;
    }

    /**
     * Generate CSV content from array
     */
    private function generateCsvFromArray($array, $nameField, $synonymField = null)
    {
        $csvContent = '';
        
        foreach ($array as $item) {
            $referenceValue = $item[$nameField];
            $synonyms = '';
            
            if ($synonymField && isset($item[$synonymField])) {
                $synonyms = ', ' . $item[$synonymField];
            }
            
            // Include the reference value twice if you want it to be matched by the entity
            $csvContent .= '"' . $referenceValue . '", "' . $referenceValue . $synonyms . '"' . "\n";
        }
        
        return $csvContent;
    }

    /**
     * Download CSV file
     */
    private function downloadCsv($content, $filename)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response($content, 200, $headers);
    }
} 