<table cellpadding="0" cellspacing="0" style="width:100%; border-collapse:collapse;line-height:1.15">
    <tbody>
        <tr>
            <td align="center">
                <img border="0" src="https://ci3.googleusercontent.com/meips/ADKq_NYKuzrYeHvAaOozNYFMMZxsFALaBck_ZItPmJzpGJo0ZwCRCQVYuMH1Z_omNsg2Kf4tDhPJnFuTLnirKhqT2fjlct53x3yzJlLqLfuunlVn6pmwJVVHzGiIOWM=s0-d-e1-ft#https://d36urhup7zbd7q.cloudfront.net/u/mpg4v1rO08A/1659791340357.png"
                    alt="photo" style="width:150px;vertical-align:middle;border-radius:0px;height:200px;border:0px;display:block"
                    class="CToWUd" data-bit="iit"><br/><br/>
            </td>
        </tr>
        <tr>
            <td>
                <p><?php echo $data->full_greeting;?></p>
                <p>
                    <?php
                    echo $data->organization_name . "<br/>"
                        . $data->street . "<br/>"
                        . $data->city
                        . (!empty($data->county) ? ", {$data->county} County" : "")
                        . ", {$data->state} {$data->zip}<br/>"
                        . "Attn: {$data->contact_person_name} <a href='mailto:{$data->email}' style='font-family:Arial;color:rgb(58, 115, 119);white-space:nowrap'>{$data->email}</a>";
                    ?>
                </p>
                <p>
                    <table>
                        <tbody>
                            <tr>
                                <td style="padding-right:30px;">Phone for Fedex Use:</td>
                                <td><?php echo $data->phone;?></td>
                            </tr>
                            @if(isset($data->envelope_quantity))
                                <tr>
                                    <td style="padding-right:30px;">Quantity of Envelopes:</td>
                                    <td><?php echo $data->envelope_quantity;?></td>
                                </tr>
                                <tr>
                                    <td style="padding-right:30px;">Quantity of Teacher Instructions Cards:</td>
                                    <td><?php echo $data->instructions_cards;?></td>
                                </tr>
                            @else
                                <tr>
                                    <td style="padding-right:30px;">Qty of Cards for Residents/Patients:</td>
                                    <td><?php echo $data->valentine_card_count;?></td>
                                </tr>
                                <tr>
                                    <td style="padding-right:30px;">Qty of Cards for staff (subject to availability):</td>
                                    <td><?php echo $data->extra_staff_cards;?></td>
                                </tr>
                            @endif
                            <tr>
                                <td style="padding-right:30px;">Standing Order:</td>
                                <td><?php echo ($data->standing_order) ? "Yes" : "No";?></td>
                            </tr>
                        </tbody>                        
                    </table>
                </p>
                <p>
                    If you need to update any information, you can click 
                    <a href='<?php echo $data->prefilled_link;?>' style='font-family:Arial;color:rgb(58, 115, 119);white-space:nowrap'>HERE</a><br/>
                    If your email system blocks the link, you can copy this link to your browser: {!! str_replace(['.', '/'], ['&#8203;.', '&#8203;/'], e($data->prefilled_link)) !!}
                </p>
                <p>Thank you.</p>
                <p>Patrick</p>
                <br/><br/>
            </td>
        </tr>
        <tr>
            <td>
                <table cellpadding="0" cellspacing="0" style="border-collapse:collapse;line-height:1.15">
                    <tbody>
                        <tr>
                            <td style="vertical-align:top;padding:0.01px 14px 0.01px 1px;width:65px;text-align:center">
                                <p style="margin:1px"><img border="0"
                                    src="https://ci3.googleusercontent.com/meips/ADKq_NYKuzrYeHvAaOozNYFMMZxsFALaBck_ZItPmJzpGJo0ZwCRCQVYuMH1Z_omNsg2Kf4tDhPJnFuTLnirKhqT2fjlct53x3yzJlLqLfuunlVn6pmwJVVHzGiIOWM=s0-d-e1-ft#https://d36urhup7zbd7q.cloudfront.net/u/mpg4v1rO08A/1659791340357.png"
                                    height="83" width="65" alt="photo"
                                    style="width:65px;vertical-align:middle;border-radius:0px;height:83px;border:0px;display:block"
                                    class="CToWUd" data-bit="iit"></p>
                            </td>
                            <td valign="top" style="padding:0.01px 0.01px 0.01px 14px;vertical-align:top;border-left:1px solid rgb(189,189,189)">
                                <table cellpadding="0" cellspacing="0" style="border-collapse:collapse">
                                    <tbody>
                                        <tr>
                                            <td style="padding:0.01px">
                                                <p style="margin:0.1px;line-height:120%;font-size:16px">
                                                    <span style="font-family:Arial;font-size:16px;font-weight:bold;color:rgb(100,100,100);letter-spacing:0px;white-space:nowrap">Patrick
                                                        Roy Kaufmann</span><br>
                                                    <span style="font-family:Arial;font-size:13px;font-weight:bold;color:rgb(100,100,100);white-space:nowrap">Founder
                                                        &amp;President,<span>&nbsp;</span></span>
                                                    <span style="font-family:Arial;font-size:13px;font-weight:bold;color:rgb(100,100,100);white-space:nowrap">Valentines
                                                        By Kids</span>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="height:0px" height="0">
                                                <table cellpadding="0" cellspacing="0" style="border-collapse:collapse">
                                                    <tbody>
                                                        <tr>
                                                            <td nowrap width="352" height="0"
                                                                style="height:0px;padding-top:14px;white-space:nowrap;width:352px;font-family:Arial">
                                                                <p style="margin:1px;line-height:99%;font-size:11px">
                                                                    <span style="white-space:nowrap">
                                                                        <a href="https://ValentinesByKids.org"
                                                                            style="font-family:Arial;text-decoration:unset"
                                                                            rel="nofollow noreferrer" target="_blank"
                                                                            data-saferedirecturl="https://www.google.com/url?q=https://ValentinesByKids.org&amp;source=gmail&amp;ust=1761018178749000&amp;usg=AOvVaw3mr-NnjBkovWhdVqLym5oN">
                                                                            <span style="line-height:120%;font-family:Arial;font-size:11px;color:rgb(33,33,33);white-space:nowrap">ValentinesByKids.org</span>
                                                                        </a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                                                        <a href="mailto:Patrick@ValentinesByKids.org"
                                                                            style="font-family:Arial;text-decoration:unset"
                                                                            rel="nofollow noreferrer" target="_blank">
                                                                            <span style="line-height:120%;font-family:Arial;font-size:11px;color:rgb(33,33,33);white-space:nowrap">Patri<wbr>ck@ValentinesByKids.org</span>
                                                                        </a>
                                                                    </span>
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td nowrap width="440" height="0" style="height:0px;padding-top:8px;white-space:nowrap;width:440px;font-family:Arial">
                                                                <p style="margin:1px;line-height:99%;font-size:11px">
                                                                    <span style="white-space:nowrap">
                                                                        <span style="font-family:Arial;line-height:1.2;color:rgb(33,33,33);font-size:11px;white-space:nowrap">
                                                                            43,000 kids strong in 2025!
                                                                            I am in High School during the day.</span>
                                                                    </span>
                                                                </p>
                                                            </td>
                                                        </tr>
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
            </td>
        </tr>
    </tbody>    
</table>
