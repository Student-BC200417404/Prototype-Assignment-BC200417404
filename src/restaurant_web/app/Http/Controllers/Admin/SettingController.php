<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = $this->getSettings();
        return view('admin.pages.setting.index', compact('settings'));
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'restaurant_name' => 'required|string|max:255',
                'restaurant_email' => 'required|email',
                'restaurant_phone' => 'required|string|max:20',
                'restaurant_address' => 'required|string',
                'restaurant_description' => 'nullable|string',
                'opening_hours' => 'required|string',
                'tax_rate' => 'required|numeric|min:0|max:100',
                'delivery_fee' => 'required|numeric|min:0',
                'minimum_order' => 'required|numeric|min:0',
                'currency' => 'required|string|max:10',
                'timezone' => 'required|string',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'favicon' => 'nullable|image|mimes:ico,png|max:1024',
                'social_facebook' => 'nullable|url',
                'social_twitter' => 'nullable|url',
                'social_instagram' => 'nullable|url',
                'social_youtube' => 'nullable|url',
                'google_analytics' => 'nullable|string',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
                'meta_keywords' => 'nullable|string',
            ]);

            $settings = $request->except(['_token', '_method', 'logo', 'favicon']);

            // Handle logo upload
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('settings', 'public');
                $settings['logo'] = $logoPath;
            }

            // Handle favicon upload
            if ($request->hasFile('favicon')) {
                $faviconPath = $request->file('favicon')->store('settings', 'public');
                $settings['favicon'] = $faviconPath;
            }

            // Save settings to cache and database
            $this->saveSettings($settings);

            return redirect()->route('admin.settings.index')
                ->with('success', 'Settings updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Please correct the errors below.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update settings. Please try again.');
        }
    }

    public function reset()
    {
        try {
            // Reset to default settings
            $defaultSettings = [
                'restaurant_name' => 'SpicyHunt Restaurant',
                'restaurant_email' => 'info@spicyhunt.com',
                'restaurant_phone' => '+1 (555) 123-4567',
                'restaurant_address' => '123 Main Street, City, State 12345',
                'restaurant_description' => 'Authentic Indian cuisine with a modern twist',
                'opening_hours' => 'Monday - Sunday: 11:00 AM - 10:00 PM',
                'tax_rate' => 8.5,
                'delivery_fee' => 5.00,
                'minimum_order' => 15.00,
                'currency' => 'USD',
                'timezone' => 'America/New_York',
                'social_facebook' => '',
                'social_twitter' => '',
                'social_instagram' => '',
                'social_youtube' => '',
                'google_analytics' => '',
                'meta_title' => 'SpicyHunt Restaurant - Authentic Indian Cuisine',
                'meta_description' => 'Experience authentic Indian cuisine with a modern twist at SpicyHunt Restaurant.',
                'meta_keywords' => 'Indian restaurant, authentic cuisine, spicy food, delivery, takeaway',
            ];

            $this->saveSettings($defaultSettings);

            return redirect()->route('admin.settings.index')
                ->with('success', 'Settings reset to default successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to reset settings. Please try again.');
        }
    }

    public function backup()
    {
        try {
            $settings = $this->getSettings();
            $filename = 'settings_backup_' . date('Y-m-d_H-i-s') . '.json';
            
            $backupPath = storage_path('app/backups/' . $filename);
            
            // Ensure backup directory exists
            if (!file_exists(dirname($backupPath))) {
                mkdir(dirname($backupPath), 0755, true);
            }
            
            file_put_contents($backupPath, json_encode($settings, JSON_PRETTY_PRINT));

            return response()->download($backupPath)->deleteFileAfterSend();

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create backup. Please try again.');
        }
    }

    public function restore(Request $request)
    {
        try {
            $request->validate([
                'backup_file' => 'required|file|mimes:json|max:1024',
            ]);

            $content = file_get_contents($request->file('backup_file')->getRealPath());
            $settings = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid backup file format.');
            }

            $this->saveSettings($settings);

            return redirect()->route('admin.settings.index')
                ->with('success', 'Settings restored successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->with('error', 'Please select a valid backup file.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to restore settings. Please try again.');
        }
    }

    private function getSettings()
    {
        return Cache::remember('restaurant_settings', 3600, function () {
            // In a real application, you might store settings in a database table
            // For now, we'll return default settings
            return [
                'restaurant_name' => config('app.name', 'SpicyHunt Restaurant'),
                'restaurant_email' => config('mail.from.address', 'info@spicyhunt.com'),
                'restaurant_phone' => '+1 (555) 123-4567',
                'restaurant_address' => '123 Main Street, City, State 12345',
                'restaurant_description' => 'Authentic Indian cuisine with a modern twist',
                'opening_hours' => 'Monday - Sunday: 11:00 AM - 10:00 PM',
                'tax_rate' => 8.5,
                'delivery_fee' => 5.00,
                'minimum_order' => 15.00,
                'currency' => 'USD',
                'timezone' => 'America/New_York',
                'logo' => null,
                'favicon' => null,
                'social_facebook' => '',
                'social_twitter' => '',
                'social_instagram' => '',
                'social_youtube' => '',
                'google_analytics' => '',
                'meta_title' => 'SpicyHunt Restaurant - Authentic Indian Cuisine',
                'meta_description' => 'Experience authentic Indian cuisine with a modern twist at SpicyHunt Restaurant.',
                'meta_keywords' => 'Indian restaurant, authentic cuisine, spicy food, delivery, takeaway',
            ];
        });
    }

    private function saveSettings($settings)
    {
        // In a real application, you would save to a database table
        // For now, we'll just cache the settings
        Cache::put('restaurant_settings', $settings, 3600);
    }
}
