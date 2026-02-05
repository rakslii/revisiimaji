<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUsSection;
use App\Models\TeamMember;
use App\Models\Achievement;
use App\Models\CoreValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AboutUsController extends Controller
{
    /**
     * Display about us settings index
     */
      public function index(Request $request)
    {
        $tab = $request->get('tab', 'sections');
        
        // Inisialisasi data dengan array kosong
        $data = [
            'sections' => collect(),
            'teamMembers' => collect(),
            'achievements' => collect(),
            'values' => collect()
        ];
        
        // Get data based on selected tab
        switch ($tab) {
            case 'sections':
                $data['sections'] = AboutUsSection::orderBy('order')->get();
                break;
                
            case 'team':
                $data['teamMembers'] = TeamMember::orderBy('order')->get();
                break;
                
            case 'achievements':
                $data['achievements'] = Achievement::orderBy('order')->get();
                break;
                
            case 'values':
                $data['values'] = CoreValue::orderBy('order')->get();
                break;
        }
        
        // Section types for forms
        $sectionTypes = [
            'hero' => 'Hero Section',
            'story' => 'Our Story',
            'mission' => 'Mission & Vision',
            'values' => 'Core Values',
            'team' => 'Team Members',
            'stats' => 'Achievements/Stats',
            'technology' => 'Technology & Equipment',
            'cta' => 'Call to Action'
        ];
        
        // Icon options
        $iconOptions = [
            'fas fa-star' => 'Star',
            'fas fa-rocket' => 'Rocket',
            'fas fa-heart' => 'Heart',
            'fas fa-users' => 'Users',
            'fas fa-award' => 'Award',
            'fas fa-trophy' => 'Trophy',
            'fas fa-lightbulb' => 'Lightbulb',
            'fas fa-cogs' => 'Cogs',
            'fas fa-paint-brush' => 'Paint Brush',
            'fas fa-handshake' => 'Handshake',
            'fas fa-clock' => 'Clock',
            'fas fa-chart-line' => 'Chart Line',
            'fas fa-globe' => 'Globe',
            'fas fa-mobile-alt' => 'Mobile',
            'fas fa-desktop' => 'Desktop',
            'fas fa-print' => 'Printer',
            'fas fa-palette' => 'Palette',
            'fas fa-cut' => 'Cut',
            'fas fa-tachometer-alt' => 'Speed',
            'fas fa-shield-alt' => 'Shield',
            'fas fa-gem' => 'Gem',
            'fas fa-crown' => 'Crown',
            'fas fa-bolt' => 'Bolt',
        ];
        
        return view('pages.admin.settings.about-us.index', compact('tab', 'data', 'sectionTypes', 'iconOptions'));
    }

    // ==================== SECTIONS CRUD ====================

    public function storeSection(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'section_type' => 'required|in:hero,story,mission,values,team,stats,technology,cta',
            'position' => 'nullable|string|max:50',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'background_color' => 'nullable|string|max:50',
            'text_color' => 'nullable|string|max:50',
            'icon' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('tab', 'sections');
        }

        try {
            $sectionData = $validator->validated();
            $sectionData['is_active'] = $request->boolean('is_active');
            $sectionData['order'] = $request->order ?? 0;

            AboutUsSection::create($sectionData);

            return redirect()->route('admin.settings.about-us.index', ['tab' => 'sections'])
                ->with('success', 'Section created successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create section: ' . $e->getMessage())
                ->withInput()
                ->with('tab', 'sections');
        }
    }

    public function updateSection(Request $request, $id)
    {
        $section = AboutUsSection::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'section_type' => 'required|in:hero,story,mission,values,team,stats,technology,cta',
            'position' => 'nullable|string|max:50',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'background_color' => 'nullable|string|max:50',
            'text_color' => 'nullable|string|max:50',
            'icon' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('tab', 'sections');
        }

        try {
            $sectionData = $validator->validated();
            $sectionData['is_active'] = $request->boolean('is_active');
            $sectionData['order'] = $request->order ?? 0;

            $section->update($sectionData);

            return redirect()->route('admin.settings.about-us.index', ['tab' => 'sections'])
                ->with('success', 'Section updated successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update section: ' . $e->getMessage())
                ->withInput()
                ->with('tab', 'sections');
        }
    }

    public function destroySection($id)
    {
        $section = AboutUsSection::findOrFail($id);

        try {
            $section->delete();

            return redirect()->route('admin.settings.about-us.index', ['tab' => 'sections'])
                ->with('success', 'Section deleted successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete section: ' . $e->getMessage())
                ->with('tab', 'sections');
        }
    }

    public function toggleSectionStatus($id)
    {
        $section = AboutUsSection::findOrFail($id);

        try {
            $section->update([
                'is_active' => !$section->is_active
            ]);

            $status = $section->is_active ? 'activated' : 'deactivated';

            return redirect()->back()
                ->with('success', "Section {$status} successfully.")
                ->with('tab', 'sections');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to toggle status: ' . $e->getMessage())
                ->with('tab', 'sections');
        }
    }

    // ==================== TEAM MEMBERS CRUD ====================

    public function storeTeamMember(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'initial' => 'nullable|string|max:5',
            'color_scheme' => 'nullable|string|max:100',
            'social_linkedin' => 'nullable|url|max:255',
            'social_instagram' => 'nullable|url|max:255',
            'social_twitter' => 'nullable|url|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('tab', 'team');
        }

        try {
            $teamData = [
                'name' => $request->name,
                'position' => $request->position,
                'bio' => $request->bio,
                'initial' => $request->initial,
                'color_scheme' => $request->color_scheme,
                'order' => $request->order ?? 0,
                'is_active' => $request->boolean('is_active'),
                'social_links' => [
                    'linkedin' => $request->social_linkedin,
                    'instagram' => $request->social_instagram,
                    'twitter' => $request->social_twitter,
                ]
            ];

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('team-members', 'public');
                $teamData['image'] = $path;
            }

            TeamMember::create($teamData);

            return redirect()->route('admin.settings.about-us.index', ['tab' => 'team'])
                ->with('success', 'Team member created successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create team member: ' . $e->getMessage())
                ->withInput()
                ->with('tab', 'team');
        }
    }

    public function updateTeamMember(Request $request, $id)
    {
        $member = TeamMember::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'initial' => 'nullable|string|max:5',
            'color_scheme' => 'nullable|string|max:100',
            'social_linkedin' => 'nullable|url|max:255',
            'social_instagram' => 'nullable|url|max:255',
            'social_twitter' => 'nullable|url|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('tab', 'team');
        }

        try {
            $teamData = [
                'name' => $request->name,
                'position' => $request->position,
                'bio' => $request->bio,
                'initial' => $request->initial,
                'color_scheme' => $request->color_scheme,
                'order' => $request->order ?? 0,
                'is_active' => $request->boolean('is_active'),
                'social_links' => [
                    'linkedin' => $request->social_linkedin,
                    'instagram' => $request->social_instagram,
                    'twitter' => $request->social_twitter,
                ]
            ];

            if ($request->hasFile('image')) {
                // Delete old image
                if ($member->image) {
                    Storage::disk('public')->delete($member->image);
                }
                
                $path = $request->file('image')->store('team-members', 'public');
                $teamData['image'] = $path;
            }

            $member->update($teamData);

            return redirect()->route('admin.settings.about-us.index', ['tab' => 'team'])
                ->with('success', 'Team member updated successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update team member: ' . $e->getMessage())
                ->withInput()
                ->with('tab', 'team');
        }
    }

    public function destroyTeamMember($id)
    {
        $member = TeamMember::findOrFail($id);

        try {
            // Delete image if exists
            if ($member->image) {
                Storage::disk('public')->delete($member->image);
            }

            $member->delete();

            return redirect()->route('admin.settings.about-us.index', ['tab' => 'team'])
                ->with('success', 'Team member deleted successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete team member: ' . $e->getMessage())
                ->with('tab', 'team');
        }
    }

    // ==================== ACHIEVEMENTS CRUD ====================

    public function storeAchievement(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
            'value' => 'required|string|max:50',
            'suffix' => 'nullable|string|max:10',
            'description' => 'nullable|string|max:500',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('tab', 'achievements');
        }

        try {
            $achievementData = $validator->validated();
            $achievementData['is_active'] = $request->boolean('is_active');
            $achievementData['order'] = $request->order ?? 0;

            Achievement::create($achievementData);

            return redirect()->route('admin.settings.about-us.index', ['tab' => 'achievements'])
                ->with('success', 'Achievement created successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create achievement: ' . $e->getMessage())
                ->withInput()
                ->with('tab', 'achievements');
        }
    }

    public function updateAchievement(Request $request, $id)
    {
        $achievement = Achievement::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
            'value' => 'required|string|max:50',
            'suffix' => 'nullable|string|max:10',
            'description' => 'nullable|string|max:500',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('tab', 'achievements');
        }

        try {
            $achievementData = $validator->validated();
            $achievementData['is_active'] = $request->boolean('is_active');
            $achievementData['order'] = $request->order ?? 0;

            $achievement->update($achievementData);

            return redirect()->route('admin.settings.about-us.index', ['tab' => 'achievements'])
                ->with('success', 'Achievement updated successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update achievement: ' . $e->getMessage())
                ->withInput()
                ->with('tab', 'achievements');
        }
    }

    public function destroyAchievement($id)
    {
        $achievement = Achievement::findOrFail($id);

        try {
            $achievement->delete();

            return redirect()->route('admin.settings.about-us.index', ['tab' => 'achievements'])
                ->with('success', 'Achievement deleted successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete achievement: ' . $e->getMessage())
                ->with('tab', 'achievements');
        }
    }

    // ==================== CORE VALUES CRUD ====================

    public function storeCoreValue(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'icon' => 'required|string|max:50',
            'color_scheme' => 'nullable|string|max:100',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('tab', 'values');
        }

        try {
            $valueData = $validator->validated();
            $valueData['is_active'] = $request->boolean('is_active');
            $valueData['order'] = $request->order ?? 0;

            CoreValue::create($valueData);

            return redirect()->route('admin.settings.about-us.index', ['tab' => 'values'])
                ->with('success', 'Core value created successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create core value: ' . $e->getMessage())
                ->withInput()
                ->with('tab', 'values');
        }
    }

    public function updateCoreValue(Request $request, $id)
    {
        $value = CoreValue::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'icon' => 'required|string|max:50',
            'color_scheme' => 'nullable|string|max:100',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('tab', 'values');
        }

        try {
            $valueData = $validator->validated();
            $valueData['is_active'] = $request->boolean('is_active');
            $valueData['order'] = $request->order ?? 0;

            $value->update($valueData);

            return redirect()->route('admin.settings.about-us.index', ['tab' => 'values'])
                ->with('success', 'Core value updated successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update core value: ' . $e->getMessage())
                ->withInput()
                ->with('tab', 'values');
        }
    }

    public function destroyCoreValue($id)
    {
        $value = CoreValue::findOrFail($id);

        try {
            $value->delete();

            return redirect()->route('admin.settings.about-us.index', ['tab' => 'values'])
                ->with('success', 'Core value deleted successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete core value: ' . $e->getMessage())
                ->with('tab', 'values');
        }
    }

    // ==================== REORDER METHODS ====================

    public function reorderSections(Request $request)
    {
        $request->validate([
            'sections' => 'required|array',
            'sections.*.id' => 'required|exists:about_us_sections,id',
            'sections.*.order' => 'required|integer|min:0',
        ]);

        try {
            foreach ($request->sections as $item) {
                AboutUsSection::where('id', $item['id'])->update(['order' => $item['order']]);
            }

            return response()->json(['success' => true, 'message' => 'Order updated successfully.']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update order.'], 500);
        }
    }

    public function reorderTeam(Request $request)
    {
        $request->validate([
            'team' => 'required|array',
            'team.*.id' => 'required|exists:team_members,id',
            'team.*.order' => 'required|integer|min:0',
        ]);

        try {
            foreach ($request->team as $item) {
                TeamMember::where('id', $item['id'])->update(['order' => $item['order']]);
            }

            return response()->json(['success' => true, 'message' => 'Order updated successfully.']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update order.'], 500);
        }
    }

    public function reorderAchievements(Request $request)
    {
        $request->validate([
            'achievements' => 'required|array',
            'achievements.*.id' => 'required|exists:achievements,id',
            'achievements.*.order' => 'required|integer|min:0',
        ]);

        try {
            foreach ($request->achievements as $item) {
                Achievement::where('id', $item['id'])->update(['order' => $item['order']]);
            }

            return response()->json(['success' => true, 'message' => 'Order updated successfully.']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update order.'], 500);
        }
    }

    public function reorderValues(Request $request)
    {
        $request->validate([
            'values' => 'required|array',
            'values.*.id' => 'required|exists:core_values,id',
            'values.*.order' => 'required|integer|min:0',
        ]);

        try {
            foreach ($request->values as $item) {
                CoreValue::where('id', $item['id'])->update(['order' => $item['order']]);
            }

            return response()->json(['success' => true, 'message' => 'Order updated successfully.']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update order.'], 500);
        }
    }
}