<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- <link href="https://fonts.googleapis.com/css?family=Lato&amp;display=swap" rel="stylesheet"> --}}
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

    <style type="text/css">
        .cursive {
            font-family: 'Dancing Script', cursive;
            /* font-family: "Pinyon Script", cursive; */
        }

        .sans {
            font-family: "Open Sans", sans-serif;
        }

        .bold {
            font-weight: bold;
        }

        .block {
            display: block;
        }

        .underline {
            border-bottom: 1px solid #777;
            padding: 5px;
            margin-bottom: 15px;
        }

        .margin-0 {
            margin: 0;
        }

        .padding-0 {
            padding: 0;
        }

        .pm-empty-space {
            height: 40px;
            width: 100%;
        }

        /* body {
            padding: 20px 0;
        } */
        .pm-certificate-container {
            position: relative;
            width: 80%;
            margin: 0 auto;
            padding: 4px 4px;
            color: #333;
            font-family: "Open Sans", sans-serif;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
        }
        .pm-certificate-container .outer-border {
            border: 2px solid #fff;
        }

        .pm-certificate-container .inner-border {
            padding: 4px;
            border: 2px solid #fff;
            margin: 30px 30px;  
        }
       

        .pm-certificate-container .pm-certificate-border {
            position: relative;
            padding: 0px 20px;
            border: 1px solid #E1E5F0;
            background-color: #FFFFFF;
            background-image: none;
         
        }

        .pm-certificate-container .pm-certificate-border .pm-certificate-block {
            width: 100%;
            /* height: 200px; */
            position: relative;
            /* left: 50%; */
            /* margin-left: -325px; */
            /* top: 70px; */
            margin-top: 0;
        }

        .pm-certificate-container .pm-certificate-border .pm-certificate-header {
            margin-bottom: 10px;
        }

        .pm-certificate-container .pm-certificate-border .pm-certificate-title h2 {
            font-size: 34px !important;
            padding: 35px 0 20px;
        }

        .pm-course-title {
            padding-top: 15px;
            width: 60%;
            margin: 0 auto;
            text-align: center;
        }

        .w-100 {
            width: 100%;
        }
        .text-center {
            text-align: center;
        }
        .pm-certificate-container .pm-certificate-border .pm-certificate-body {
            padding: 10px 20px;
            width: 100%;
            display: block;
        }

        .pm-certificate-container .pm-certificate-border .pm-certificate-body .pm-name-text {
            font-size: 20px;
        }

        .pm-certificate-container .pm-certificate-border .pm-earned {
            margin: 15px 0 20px;
            width: 100%;
            text-align: center;
        }

        .pm-certificate-container .pm-certificate-border .pm-earned .pm-earned-text {
            font-size: 25px;
        }

        .pm-certificate-container .pm-certificate-border .pm-earned .pm-credits-text {
            font-size: 15px;
            padding: 10px 0 0;
        }

        .pm-certificate-container .pm-certificate-border .pm-course-title .pm-earned-text {
            font-size: 22px;
        }

        .pm-certificate-container .pm-certificate-border .pm-course-title .pm-credits-text {
            font-size: 15px;
        }

        .pm-certificate-container .pm-certificate-border .pm-certified {
            font-size: 12px;
            width: 30%;
            padding: 20px 0;
        }

        .pm-certificate-container .pm-certificate-border .pm-certified .underline {
            margin-bottom: 5px;
        }

        .pm-certificate-container .pm-certificate-border .pm-certificate-footer {
            width: 100%;
            display: flex;
            padding: 30px 0 0px;
            align-items: center;
            justify-content: space-between;
        }
      
        .certificate_iframe {
            display: block;
            height: 720px;
            overflow: hidden;
            /* background: #f5f8fa; */
            padding-top: 60px;
        }

        .certificate_frame body {
            margin-top: 40px;
        } 
        .pm-certificate-name {
            margin: 0 auto;
            width: 60%;
            text-align: center;
        }

    </style>

</head>
@php
    $border_color = ($color == '#FFFFFF') ? 'black' : $color;
@endphp

<body data-new-gr-c-s-check-loaded="14.1040.0" data-gr-ext-installed="">
    <div class="container">
        <div class="pm-certificate-container" style="background : {{ $color }}">
            <div class="outer-border">
                <div class="inner-border">
                    <div class="pm-certificate-border col-xs-12">
                        <div class="row pm-certificate-header">
                            <div class="pm-certificate-title cursive col-xs-12 text-center w-100">
                                <h2>{{ isset($settings->header_name)?$settings->header_name:'{store_name}'}}</h2>
                            </div>
                        </div>
                        <div class="row pm-certificate-body">
                            
                            <div class="pm-certificate-block">
                                <div class="col-xs-12">
                                    <div class="row">
                                        <div class="col-xs-2">
                                            <!-- LEAVE EMPTY -->
                                        </div>
                                        <div class="pm-certificate-name underline margin-auto col-xs-8 text-center">
                                            <span class="pm-name-text bold">TrueNorth Administrator</span>
                                        </div>
                                        <div class="col-xs-2">
                                            <!-- LEAVE EMPTY -->
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-xs-12">
                                    <div class="row">
                                        <div class="col-xs-2">
                                            <!-- LEAVE EMPTY -->
                                        </div>
                                        <div class="pm-earned col-xs-8 text-center">
                                            <span class="pm-earned-text padding-0 block cursive">has earned</span>
                                            <span class="pm-credits-text block bold sans">PD175: 1.0 Credit Hours</span>
                                        </div>
                                        <div class="col-xs-2">
                                            <!-- LEAVE EMPTY -->
                                        </div>
                                        <div class="col-xs-12"></div>
                                    </div>
                                </div>
                                
                                <div class="col-xs-12">
                                    <div class="row">
                                        <div class="col-xs-2">
                                            <!-- LEAVE EMPTY -->
                                        </div>
                                        <div class="pm-course-title col-xs-8 text-center">
                                            <span class="pm-earned-text block cursive">while completing the training course entitled</span>
                                        </div>
                                        <div class="col-xs-2">
                                            <!-- LEAVE EMPTY -->
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-xs-12">
                                    <div class="row">
                                        <div class="col-xs-2">
                                            <!-- LEAVE EMPTY -->
                                        </div>
                                        <div class="pm-course-title underline col-xs-8 text-center">
                                            <span class="pm-credits-text block bold sans">BPS PGS Initial PLO for Principals at Cluster Meetings</span>
                                        </div>
                                        <div class="col-xs-2">
                                            <!-- LEAVE EMPTY -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-12">
                                <div class="row pm-certificate-body">
                                    <div class="pm-certificate-footer">
                                        <div class="col-xs-4 pm-certified col-xs-4 text-center">
                                            <span class="pm-credits-text block sans">Buffalo City School District</span>
                                            <span class="pm-empty-space block underline"></span>
                                            <span class="bold block">Crystal Benton Instructional Specialist II, Staff Development</span>
                                        </div>
                                        <div class="col-xs-4">
                                            <!-- LEAVE EMPTY -->
                                        </div>
                                        <div class="col-xs-4 pm-certified col-xs-4 text-center">
                                            <span class="pm-credits-text block sans">Date Completed</span>
                                            <span class="pm-empty-space block underline"></span>
                                            <span class="bold block">DOB: </span>
                                            <span class="bold block">Social Security # (last 4 digits)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- {{ dd('gfhxf') }} --}}
</body>

</html>
