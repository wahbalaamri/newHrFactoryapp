<?php

namespace App\Http\Controllers;

use App\Http\Facades\TempURL;
use App\Models\Services;
use App\Http\Requests\StoreServicesRequest;
use App\Http\Requests\UpdateServicesRequest;
use App\Models\Clients;
use App\Models\Countries;
use App\Models\PartnerFocalPoint;
use App\Models\Partnerships;
use App\Models\ServiceApproaches;
use App\Models\ServiceFeatures;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'services' => Services::all(),
        ];
        return view('dashboard.services.index')->with($data);
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('dashboard.services.edit');
        $data = [
            //countries group by IsArabCountry
            'countries' => Countries::all()->groupBy('IsArabCountry'),
            'service' => null,
            'clients' => Clients::all()->count(),
        ];
        return view('dashboard.services.edit')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServicesRequest $request)
    {
        $image_name = "";
        $fw_video_name = "";
        $ar_video_name = "";
        $icon_name = "";
        $FW_uploaded_video = false;
        $FW_uploaded_video_ar = false;
        // check for service_icon file
        if ($request->hasFile('service_icon')) {
            // Get icon file
            $icon = $request->file('service_icon');
            // Folder path
            $folder = 'uploads/services/icons/';
            // Make icon name with original name

            $icon_name = date('YmdHis') . '-' . $icon->getClientOriginalName();
            // Upload icon
            $icon->move(public_path($folder), $icon_name);
        }
        // check for image file
        if ($request->hasFile('image')) {
            // Get image file
            $image = $request->file('image');
            // Folder path
            $folder = 'uploads/services/images/';
            // Make image name with original name

            $image_name = date('YmdHis') . '-' . $image->getClientOriginalName();
            // Upload image
            $image->move(public_path($folder), $image_name);
        }
        // check for fw_video file
        if ($request->hasFile('framework_video')) {
            // Get framework_video file
            $fw_video = $request->file('framework_video');
            // Folder path
            $folder = 'uploads/services/videos/';
            // Make fw_video name with original name

            $fw_video_name = date('YmdHis') . '-' . $fw_video->getClientOriginalName();
            // Upload fw_video
            $fw_video->move(public_path($folder), $fw_video_name);
            $FW_uploaded_video = true;
        }
        // check for fw_video_ar file
        if ($request->hasFile('framework_video_ar')) {
            // Get framework_video_ar file
            $fw_video_ar = $request->file('framework_video_ar');
            // Folder path
            $folder = 'uploads/services/videos/';
            // Make fw_video_ar name with original name

            $fw_video_name_ar = date('YmdHis') . '-' . $fw_video_ar->getClientOriginalName();
            // Upload fw_video_ar
            $fw_video_ar->move(public_path($folder), $fw_video_name_ar);
            $FW_uploaded_video_ar = true;
        }
        if (!$FW_uploaded_video && $request->youtube_url != '') {
            $fw_video_name = $request->youtube_url;
        }
        if (!$FW_uploaded_video_ar && $request->youtube_url_ar != '') {
            $fw_video_name_ar = $request->youtube_url_ar;
        }
        $service = new Services();
        $service->name = $request->name;
        $service->name_ar = $request->name_ar;
        //slug
        $service->slug =  $request->slug;
        //slug_ar
        $service->slug_ar =  $request->slug_ar;
        $service->description = $request->description;
        $service->description_ar = $request->description_ar;
        //service_icon
        $service->service_icon = $icon_name;
        $service->service_media_path = $image_name;
        $service->service_fileType = 1;
        $service->service_uploaded_video = false;
        $service->service_type = $request->type;
        $service->FW_uploaded_video = $FW_uploaded_video;
        $service->framework_media_path = $fw_video_name;
        $service->FW_uploaded_video_ar = $FW_uploaded_video_ar;
        $service->framework_media_path_ar = $fw_video_name_ar;
        $service->country = $request->country;
        $service->objective = $request->objectives;
        $service->objective_ar = $request->objectives_ar;
        $service->service_user = 0;
        $service->is_active = true;
        $service->candidate_raters_model = $request->candidate_raters_model != null ? true : false;
        $service->public_availability = $request->public_availability != null ? true : false;
        $service->save();

        //servcie features
        //get the array of features
        $features = $request->feature;
        $features_ar = $request->feature_ar;
        //loop through the array
        if ((count($features) > 0) && $features[0] != null && $features_ar[0] != null) {
            for ($i = 0; $i < count($features); $i++) {
                //create a new service feature
                $service_feature = new ServiceFeatures();
                $service_feature->service = $service->id;
                $service_feature->feature = $features[$i];
                $service_feature->feature_ar = $features_ar[$i];
                $service_feature->save();
            }
        }
        //service approaches
        //get the array of approaches
        $approaches = $request->approach;
        $approaches_ar = $request->approach_ar;
        //get array of approach icons
        $approach_icons = $request->icon;
        if ((count($approaches) > 0) && $approaches[0] != null && $approaches_ar[0] != null && $approach_icons[0] != null) {
            //loop through the array
            for ($i = 0; $i < count($approaches); $i++) {
                //upload the icon
                $icon_name = "";
                if ($request->hasFile('icon')) {
                    // Get icon file
                    $icon = $request->file('icon')[$i];
                    // Folder path
                    $folder = 'uploads/services/icons/';
                    // Make icon name with original name

                    $icon_name = date('YmdHis') . '-' . $icon->getClientOriginalName();
                    // Upload icon
                    $icon->move(public_path($folder), $icon_name);
                }
                //create a new service approach
                $service_approach = new ServiceApproaches();
                $service_approach->service = $service->id;
                $service_approach->approach = $approaches[$i];
                $service_approach->approach_ar = $approaches_ar[$i];
                $service_approach->icon = $icon_name;
                $service_approach->save();
            }
        }
        return redirect()->route('services.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $data = [
            'service' => Services::find($id),

        ];
        return view('dashboard.services.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        // return view('dashboard.services.edit');
        $data = [
            //countries group by IsArabCountry
            'countries' => Countries::all()->groupBy('IsArabCountry'),
            'service' => Services::find($id),
            'clients' => Clients::all()->count(),
        ];
        return view('dashboard.services.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServicesRequest $request,  $id)
    {
        //
        $image_name = "";
        $fw_video_name = "";
        $ar_video_name = "";
        $icon_name = "";
        $FW_uploaded_video = false;
        $FW_uploaded_video_ar = false;
        // check for service_icon file
        if ($request->hasFile('service_icon')) {
            // Get icon file
            $icon = $request->file('service_icon');
            // Folder path
            $folder = 'uploads/services/icons/';
            // Make icon name with original name

            $icon_name = date('YmdHis') . '-' . $icon->getClientOriginalName();
            // Upload icon
            $icon->move(public_path($folder), $icon_name);
        }
        // check for image file
        if ($request->hasFile('image')) {
            // Get image file
            $image = $request->file('image');
            // Folder path
            $folder = 'uploads/services/images/';
            // Make image name with original name

            $image_name = date('YmdHis') . '-' . $image->getClientOriginalName();
            // Upload image
            $image->move(public_path($folder), $image_name);
        }
        // check for fw_video file
        if ($request->hasFile('framework_video')) {
            // Get framework_video file
            $fw_video = $request->file('framework_video');
            // Folder path
            $folder = 'uploads/services/videos/';
            // Make fw_video name with original name

            $fw_video_name = date('YmdHis') . '-' . $fw_video->getClientOriginalName();
            // Upload fw_video
            $fw_video->move(public_path($folder), $fw_video_name);
            $FW_uploaded_video = true;
        }
        // check for fw_video_ar file
        if ($request->hasFile('framework_video_ar')) {
            // Get framework_video_ar file
            $fw_video_ar = $request->file('framework_video_ar');
            // Folder path
            $folder = 'uploads/services/videos/';
            // Make fw_video_ar name with original name

            $fw_video_name_ar = date('YmdHis') . '-' . $fw_video_ar->getClientOriginalName();
            // Upload fw_video_ar
            $fw_video_ar->move(public_path($folder), $fw_video_name_ar);
            $FW_uploaded_video_ar = true;
        }
        if (!$FW_uploaded_video && $request->youtube_url != '') {
            $fw_video_name = $request->youtube_url;
        }
        if (!$FW_uploaded_video_ar && $request->youtube_url_ar != '') {
            $fw_video_name_ar = $request->youtube_url_ar;
        }
        $service = Services::find($id);
        $service->name = $request->name;
        $service->name_ar = $request->name_ar;
        //slug
        $service->slug =  $request->slug;
        //slug_ar
        $service->slug_ar =  $request->slug_ar;
        $service->description = $request->description;
        $service->description_ar = $request->description_ar;
        //service_icon
        $service->service_icon = $icon_name != "" ? $icon_name : $service->service_icon;
        $service->service_media_path = $image_name != "" ? $image_name : $service->service_media_path;
        $service->service_fileType = 1;
        $service->service_uploaded_video = false;
        $service->service_type = $request->type;
        $service->FW_uploaded_video = $FW_uploaded_video;
        $service->framework_media_path = $fw_video_name;
        $service->FW_uploaded_video_ar = $FW_uploaded_video_ar;
        $service->framework_media_path_ar = $fw_video_name_ar;
        $service->country = $request->country;
        $service->objective = $request->objectives;
        $service->objective_ar = $request->objectives_ar;
        $service->service_user = 0;
        $service->is_active = true;
        $service->candidate_raters_model = $request->candidate_raters_model != null ? true : false;
        $service->public_availability = $request->public_availability != null ? true : false;
        $service->save();
        return redirect()->route('services.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Services $services)
    {
        //

    }
}
