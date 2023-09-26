<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<title>Home Collection Enquiry</title>
<link rel="stylesheet" href="{{ asset('/css/email.css') }}">
</head>

<body style="margin: 0;">
<table width="100%" id="mainStructure" border="0" cellspacing="0" cellpadding="0"
style="background-color: #e1e1e1;border-spacing: 0;">
<!-- START TAB TOP -->
<tbody>
<tr>
    <td valign="top" style="border-collapse: collapse;">
        <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0"
            style="border-spacing: 0;">
            <tbody>
                <tr>
                    <td valign="top" height="6" style="border-collapse: collapse;">
                        <table width="800" align="center" border="0" cellspacing="0" cellpadding="0"
                            class="full-width" style="border-spacing: 0;">
                            <!-- start space height -->
                            <tbody>
                                <tr>
                                    <td height="5" valign="top" style="border-collapse: collapse;">
                                    </td>
                                </tr>
                                <!-- end space height -->
                                <tr>
                                    <td height="5" class="remove" style="border-collapse: collapse;">
                                    </td>
                                </tr>
                                <!-- start space height -->
                                <tr>
                                    <td height="5" valign="top" style="border-collapse: collapse;">
                                    </td>
                                </tr>
                                <tr>
                                    <td height="5" class="remove" style="border-collapse: collapse;">
                                    </td>
                                </tr>
                                <!-- end space height -->
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </td>
</tr>
<!-- END TAB TOP -->
<!--START TOP NAVIGATION ?LAYOUT-->
<tr>
    <td align="center" valign="top" class="fix-box" style="border-collapse: collapse;">
        <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0"
            class="full-width" style="border-spacing: 0;">
            <!-- START CONTAINER NAVIGATION -->
            <tbody>
                <tr>
                    <td valign="middle" style="border-collapse: collapse;">
                        <!-- start top navigation container -->
                        <table width="800" align="center" border="0" cellspacing="0" cellpadding="0"
                            class="full-width" style="border-spacing: 0;">
                            <tbody>
                                <tr>
                                    <td valign="middle" bgcolor="663883" style="border-collapse: collapse;">
                                        <!-- start top navigation -->
                                        <table width="800" align="center" border="0" cellspacing="0"
                                            cellpadding="0" class="full-width" style="border-spacing: 0;">
                                            <tbody>
                                                <tr>
                                                    <td valign="middle" style="border-collapse: collapse;">
                                                        <table border="0" align="left" cellpadding="0"
                                                            cellspacing="0" class="container2"
                                                            style="border-spacing: 0; width:100%;">
                                                            <tbody>
                                                                <!--start event date -->
                                                                <tr>
                                                                    <td valign="middle" align="center"
                                                                        style="border-collapse: collapse;">
                                                                        <table align="center" border="0"
                                                                            cellpadding="0" cellspacing="0"
                                                                            class="clear-align"
                                                                            style="border-spacing: 0;">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td
                                                                                        style="padding:15px;border-collapse:collapse; height: 70px; text-align:center;">
                                                                                        <a href="#"
                                                                                            style="color: #fff; text-decoration: none !important;"
                                                                                            target="_blank">
                                                                                            <img title="Logo"
                                                                                                style="max-width: 300px;"
                                                                                                src="http://adladmin.pixel-studios.net/public/images/logo/logo-dark.png"></a>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <!--end content nav -->
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!-- end top navigation -->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- end top navigation container -->
                    </td>
                </tr>
                <!-- END CONTAINER NAVIGATION -->
            </tbody>
        </table>
    </td>
</tr>
<!--END TOP NAVIGATION LAYOUT-->
<!-- START MAIN CONTENT-->
<tr>
    <td align="center" valign="top" class="fix-box" style="border-collapse: collapse;">
        <!-- start layout-7 container -->

        <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0"
            class="full-width" style="border-spacing: 0;">
            <tbody>
                <tr>
                    <td valign="top" style="border-collapse: collapse;">

                        <table width="800" align="center" border="0" cellspacing="0"
                            cellpadding="0" class="container" bgcolor="#ffffff"
                            style="background-color: #ffffff;border-spacing: 0;">
                            <!--start space height -->
                            <tbody>
                                <tr>
                                    <td height="30" style="border-collapse: collapse;">
                                        <h2
                                            style="background: #fff; text-align: center; margin-bottom:0px; font-size: 24px;">
                                            FeedBack Enquiry</h2>
                                    </td>
                                </tr>
                                <!--end space height -->
                                <tr>
                                    <td style="min-height: 400px; padding: 15px; font-size: 13px;">

                                        <table width="100%">
                                            <tbody>
                                                <tr>
                                                    <td class="wrapper" width="700" align="center">
                                                        <table class="section" cellpadding="0"
                                                            cellspacing="0" width="700"
                                                            bgcolor="#f8f8f8">
                                                            <tr>
                                                                <td class="column" align="left">
                                                                    <table cellpadding="10"
                                                                        cellspacing="10">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td
                                                                                    style="padding-left:10px">
                                                                                    <strong> @if($details['type']=='feedback')Retain Name @else Name of the Organization @endif</strong>:
                                                                                </td>
                                                                                <td
                                                                                    style="padding-left:10px">
                                                                                    {!! $details['name'] !!}
                                                                                </td>
                                                                            </tr>
                                                                            @if($details['type']=='feedback')
                                                                            <tr>
                                                                                <td
                                                                                    style="padding-left:10px">
                                                                                    <strong>Mobile</strong>:
                                                                                </td>
                                                                                <td
                                                                                    style="padding-left:10px">
                                                                                    {!! $details['mobile'] !!}
                                                                                </td>
                                                                            </tr>
                                                                            @endif
                                                                            @if($details['type']=='feedback')
                                                                            <tr>
                                                                                <td
                                                                                    style="padding-left:10px">
                                                                                    <strong>Registration Number</strong>:
                                                                                </td>
                                                                                <td
                                                                                    style="padding-left:10px">
                                                                                    {!! $details['reg_no'] !!}
                                                                                </td>
                                                                            </tr>
                                                                            @endif
                                                                            @if($details['type']=='feedback')
                                                                            <tr>
                                                                                <td
                                                                                    style="padding-left:10px">
                                                                                    <strong>Branch</strong>:
                                                                                </td>
                                                                                <td
                                                                                    style="padding-left:10px">
                                                                                    {!! $details['branch'] !!}
                                                                                </td>
                                                                            </tr>
                                                                            @endif
                                                                            @if($details['type']=='feedbackb2b')
                                                                            <tr>
                                                                                <td
                                                                                    style="padding-left:10px">
                                                                                    <strong>B2B Corporate ID</strong>:
                                                                                </td>
                                                                                <td
                                                                                    style="padding-left:10px">
                                                                                    {!! $details['corporate_id'] !!}
                                                                                </td>
                                                                            </tr>
                                                                            @endif
                                                                            
                                                                            <tr>
                                                                                <td
                                                                                    style="padding-left:10px">
                                                                                    <strong>Remarks</strong>:
                                                                                </td>
                                                                                <td
                                                                                    style="padding-left:10px">
                                                                                    {!! $details['remark'] !!}
                                                                                </td>
                                                                            </tr>
                                                                            @if (!strstr($details['page_url'], 'feedback-b2b'))
                                                                                <tr>
                                                                                    <td
                                                                                        style="padding-left:10px">
                                                                                        <strong>Overall
                                                                                            experience
                                                                                            rate</strong>:
                                                                                    </td>
                                                                                    <td
                                                                                        style="padding-left:10px">
                                                                                        {{ ucfirst(str_replace('-', ' ', $details['rating_comments'])) }}
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                            @if (strstr($details['page_url'], 'feedback-b2b'))
                                                                                @foreach ($details['question_answer'] as $key => $row)
                                                                                <table cellpadding="10"
                                                                                cellspacing="10">
                                                                                <tr>
                                                                                    <th>Q.No</th>
                                                                                    <th>Question</th>
                                                                                    <th>Answer</th>
                                                                                    
                                                                                </tr>
                                                                                <tbody>
                                                                                    @foreach ($details['question_answer'] as $key => $row)
                                                                                        <tr>
                                                                                            <td>{{ $key + 1 }}
                                                                                            </td>
                                                                                            <td>{{ $row['question'] }}
                                                                                            </td>
                                                                                            <td>{{ (($row['answer']==1)?'Yes':'No') }}
                                                                                            </td>
                                                                                            
                                                                                        </tr>
                                                                                    @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                                @endforeach
                                                                            @endif
                                                                        </tbody>
                                                                    </table>
                                                                    @if (count($details['question_answer']))
                                                                        <hr>
                                                                        @if (!strstr($details['page_url'], 'feedback-b2b'))
                                                                            <table cellpadding="10"
                                                                                cellspacing="10">
                                                                                <tr>
                                                                                    <th>Q.No</th>
                                                                                    <th>Question</th>
                                                                                    <th>Answer</th>
                                                                                    
                                                                                </tr>
                                                                                <tbody>
                                                                                    @foreach ($details['question_answer'] as $key => $row)
                                                                                        <tr>
                                                                                            <td>{{ $key + 1 }}
                                                                                            </td>
                                                                                            <td>{{ $row['question'] }}
                                                                                            </td>
                                                                                            <td>{{ (($key==0)? $row['answer'] :(($row['answer']==1)?'yes':'no')) }}
                                                                                            </td>
                                                                                            
                                                                                        </tr>
                                                                                    @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        @endif
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>


                                    </td>
                                </tr>
                                <!--start space height -->
                                <tr>
                                    <td height="28" style="border-collapse: collapse;"></td>
                                </tr>
                                <!--end space height -->
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- end layout-7 container -->
    </td>
</tr>
<!-- END MAIN CONTENT-->
<!-- START FOOTER-BOX-->
<tr>
    <td align="center" valign="top" class="fix-box" style="border-collapse: collapse;">
        <!-- start layout-7 container -->
        <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0"
            class="full-width" style="border-spacing: 0;">
            <tbody>
                <tr>
                    <td valign="top" style="border-collapse: collapse;">
                        <table width="800" align="center" border="0" cellspacing="0"
                            cellpadding="0" class="full-width" bgcolor="#3a3a3a"
                            style="border-spacing: 0;">
                            <!--start space height -->
                            <tbody>
                                <tr>
                                    <td height="20" style="border-collapse: collapse;"></td>
                                </tr>
                                <!--end space height -->
                                <tr>
                                    <td valign="top" align="center" style="border-collapse: collapse;">
                                        <!-- start logo footer and address -->
                                        <table width="760" align="center" border="0"
                                            cellspacing="0" cellpadding="0" class="container"
                                            style="border-spacing: 0;">
                                            <tbody>
                                                <tr>
                                                    <td valign="top" style="border-collapse: collapse;">
                                                        <!--start icon navigation -->
                                                        <table width="100%" border="0"
                                                            align="center" cellpadding="0"
                                                            cellspacing="0" style="border-spacing: 0;">
                                                            <tbody>
                                                                <tr>
                                                                    <td valign="top" align="center"
                                                                        style="border-collapse: collapse;">
                                                                        <table width="100%"
                                                                            border="0" align="left"
                                                                            cellpadding="0"
                                                                            cellspacing="0"
                                                                            class="full-width"
                                                                            style="border-spacing: 0;">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td align="left"
                                                                                        valign="middle"
                                                                                        class="clear-padding"
                                                                                        style="border-collapse: collapse;">
                                                                                        <table
                                                                                            width="760"
                                                                                            border="0"
                                                                                            align="left"
                                                                                            cellpadding="0"
                                                                                            cellspacing="0"
                                                                                            class="col-2"
                                                                                            style="border-spacing: 0;">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td height="10"
                                                                                                        style="border-collapse: collapse;">
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td
                                                                                                        style="font-size: 13px;line-height: 15px; text-align: center; font-family: Arial,Tahoma, Helvetica, sans-serif;color: #a7a9ac;font-weight: normal;border-collapse: collapse;">
                                                                                                        ©
                                                                                                        Copyright
                                                                                                        2023.
                                                                                                        All
                                                                                                        rights
                                                                                                        reserved.
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                        <!-- end logo footer and address -->
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <!--start space height -->
                                                <tr>
                                                    <td height="20" style="border-collapse: collapse;">
                                                    </td>
                                                </tr>
                                                <!--end space height -->
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <!-- start space height -->
                                <tr>
                                    <td height="10" valign="top" style="border-collapse: collapse;">
                                    </td>
                                </tr>
                                <!-- end space height -->
                            </tbody>
                        </table>
                        <!-- end layout-FOOTER-BOX container -->
                    </td>
                </tr>
                <!-- END FOOTER-BOX-->
                <!-- START FOOTER COPY RIGHT  -->
                <tr>
                    <td align="center" valign="top" class="fix-box"
                        style="border-collapse: collapse;">
                        <!-- start layout-7 container -->
                        <table width="100%" align="center" border="0" cellspacing="0"
                            cellpadding="0" class="full-width" style="border-spacing: 0;">
                            <!-- start space height -->
                            <tbody>
                                <tr>
                                    <td height="5" valign="top" style="border-collapse: collapse;">
                                    </td>
                                </tr>
                                <!-- end space height -->

                                <!--  END FOOTER COPY RIGHT -->
                                <!-- start space height -->
                                <tr>
                                    <td height="20" valign="top" style="border-collapse: collapse;">
                                    </td>
                                </tr>
                                <!-- end space height -->
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </td>
</tr>
</tbody>
</table>
</body>

</html>
