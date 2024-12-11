@extends('frontend.layouts.app')

@section('content')

<div id="authApps">
    <section class="section-login">
        <div class="content">
            <!-- <div class="sign-img">
                <img alt="man registers by tablet"
                    src="#">
            </div> -->
            <div class="sign-form">
                <div class="sign-form_content">
                    <form action="{{ route('register') }}" method="POST" class="sign-form_content-input-part">
                        @csrf
                        <legend class="sign-form_content-title">Create an account on <span>LogistiQuote</span> </legend>

                        <div class="sign-form_content-input-part-dual-input">
                            <div class="input-wrapper @error('f_name') error @enderror">
                                <input class="input" type="text" name="f_name" value="{{ old('f_name') }}"
                                    autocomplete="first-name" placeholder=" ">
                                    <span class="placeholder">First name</span>
                                    @error('f_name')
                                        <p class="errorInputMsg">{{ $message }}</p>
                                    @enderror
                                </div>
                            <div class="input-wrapper @error('l_name') error @enderror">
                                <input class="input" type="text" name="l_name"  value="{{ old('l_name') }}" placeholder=" ">
                                    <span class="placeholder">Last name</span>
                                    @error('l_name')
                                        <p class="errorInputMsg">{{ $message }}</p>
                                    @enderror
                            </div>
                        </div>
                        
                        <div class="input-wrapper @error('email') error @enderror">
                            <input class="input" type="text" name="email" placeholder=" " value="{{ old('email') }}">
                            <span class="placeholder">E-mail</span>
                            @error('email')
                                <p class="errorInputMsg">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="select-wrapper @error('role') error @enderror" id="role">
                            <select name="role">
                                <option disabled="" value="" selected=""> Create account as</option>
                                <option data-tel="user" value="user">User</option>
                                <option data-tel="vendor" value="vendor">Vendor</option>
                            </select>
                            @error('role')
                                <p class="errorInputMsg">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="input-wrapper @error('additional_email') error @enderror" id="additional_email">
                            <input class="input" type="text" name="additional_email" placeholder=" " value="{{ old('additional_email') }}">
                            <span class="placeholder">Additional E-mail</span>
                            @error('additional_email')
                                <p class="errorInputMsg">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="select-wrapper @error('country') error @enderror">
                            <select name="country">
                                <option disabled="" value="" selected=""> Select country</option>
                                <option data-tel="93" value="AF">Afghanistan</option>
                                <option data-tel="358-18" value="AX">Aland Islands</option>
                                <option data-tel="355" value="AL">Albania</option>
                                <option data-tel="213" value="DZ">Algeria</option>
                                <option data-tel="1-684" value="AS">American Samoa</option>
                                <option data-tel="376" value="AD">Andorra</option>
                                <option data-tel="244" value="AO">Angola</option>
                                <option data-tel="1-264" value="AI">Anguilla</option>
                                <option data-tel="" value="AQ">Antarctica</option>
                                <option data-tel="1-268" value="AG">Antigua and Barbuda</option>
                                <option data-tel="54" value="AR">Argentina</option>
                                <option data-tel="374" value="AM">Armenia</option>
                                <option data-tel="297" value="AW">Aruba</option>
                                <option data-tel="61" value="AU">Australia</option>
                                <option data-tel="43" value="AT">Austria</option>
                                <option data-tel="994" value="AZ">Azerbaijan</option>
                                <option data-tel="1-242" value="BS">Bahamas</option>
                                <option data-tel="973" value="BH">Bahrain</option>
                                <option data-tel="880" value="BD">Bangladesh</option>
                                <option data-tel="1-246" value="BB">Barbados</option>
                                <option data-tel="375" value="BY">Belarus</option>
                                <option data-tel="32" value="BE">Belgium</option>
                                <option data-tel="501" value="BZ">Belize</option>
                                <option data-tel="229" value="BJ">Benin</option>
                                <option data-tel="1-441" value="BM">Bermuda</option>
                                <option data-tel="975" value="BT">Bhutan</option>
                                <option data-tel="591" value="BO">Bolivia</option>
                                <option data-tel="599" value="BQ">Bonaire, Saint Eustatius and Saba </option>
                                <option data-tel="387" value="BA">Bosnia and Herzegovina</option>
                                <option data-tel="267" value="BW">Botswana</option>
                                <option data-tel="" value="BV">Bouvet Island</option>
                                <option data-tel="55" value="BR">Brazil</option>
                                <option data-tel="246" value="IO">British Indian Ocean Territory</option>
                                <option data-tel="1-284" value="VG">British Virgin Islands</option>
                                <option data-tel="673" value="BN">Brunei</option>
                                <option data-tel="359" value="BG">Bulgaria</option>
                                <option data-tel="226" value="BF">Burkina Faso</option>
                                <option data-tel="257" value="BI">Burundi</option>
                                <option data-tel="855" value="KH">Cambodia</option>
                                <option data-tel="237" value="CM">Cameroon</option>
                                <option data-tel="1" value="CA">Canada</option>
                                <option data-tel="238" value="CV">Cape Verde</option>
                                <option data-tel="1-345" value="KY">Cayman Islands</option>
                                <option data-tel="236" value="CF">Central African Republic</option>
                                <option data-tel="235" value="TD">Chad</option>
                                <option data-tel="56" value="CL">Chile</option>
                                <option data-tel="86" value="CN">China</option>
                                <option data-tel="61" value="CX">Christmas Island</option>
                                <option data-tel="61" value="CC">Cocos Islands</option>
                                <option data-tel="57" value="CO">Colombia</option>
                                <option data-tel="269" value="KM">Comoros</option>
                                <option data-tel="682" value="CK">Cook Islands</option>
                                <option data-tel="506" value="CR">Costa Rica</option>
                                <option data-tel="385" value="HR">Croatia</option>
                                <option data-tel="53" value="CU">Cuba</option>
                                <option data-tel="599" value="CW">Curacao</option>
                                <option data-tel="357" value="CY">Cyprus</option>
                                <option data-tel="420" value="CZ">Czech Republic</option>
                                <option data-tel="243" value="CD">Democratic Republic of the Congo</option>
                                <option data-tel="45" value="DK">Denmark</option>
                                <option data-tel="253" value="DJ">Djibouti</option>
                                <option data-tel="1-767" value="DM">Dominica</option>
                                <option data-tel="1-849" value="DO">Dominican Republic</option>
                                <option data-tel="670" value="TL">East Timor</option>
                                <option data-tel="593" value="EC">Ecuador</option>
                                <option data-tel="20" value="EG">Egypt</option>
                                <option data-tel="503" value="SV">El Salvador</option>
                                <option data-tel="240" value="GQ">Equatorial Guinea</option>
                                <option data-tel="291" value="ER">Eritrea</option>
                                <option data-tel="372" value="EE">Estonia</option>
                                <option data-tel="251" value="ET">Ethiopia</option>
                                <option data-tel="500" value="FK">Falkland Islands</option>
                                <option data-tel="298" value="FO">Faroe Islands</option>
                                <option data-tel="679" value="FJ">Fiji</option>
                                <option data-tel="358" value="FI">Finland</option>
                                <option data-tel="33" value="FR">France</option>
                                <option data-tel="594" value="GF">French Guiana</option>
                                <option data-tel="689" value="PF">French Polynesia</option>
                                <option data-tel="" value="TF">French Southern Territories</option>
                                <option data-tel="241" value="GA">Gabon</option>
                                <option data-tel="220" value="GM">Gambia</option>
                                <option data-tel="995" value="GE">Georgia</option>
                                <option data-tel="49" value="DE">Germany</option>
                                <option data-tel="233" value="GH">Ghana</option>
                                <option data-tel="350" value="GI">Gibraltar</option>
                                <option data-tel="30" value="GR">Greece</option>
                                <option data-tel="299" value="GL">Greenland</option>
                                <option data-tel="1-473" value="GD">Grenada</option>
                                <option data-tel="590" value="GP">Guadeloupe</option>
                                <option data-tel="1-671" value="GU">Guam</option>
                                <option data-tel="502" value="GT">Guatemala</option>
                                <option data-tel="44-1481" value="GG">Guernsey</option>
                                <option data-tel="224" value="GN">Guinea</option>
                                <option data-tel="245" value="GW">Guinea-Bissau</option>
                                <option data-tel="592" value="GY">Guyana</option>
                                <option data-tel="509" value="HT">Haiti</option>
                                <option data-tel="" value="HM">Heard Island and McDonald Islands</option>
                                <option data-tel="504" value="HN">Honduras</option>
                                <option data-tel="852" value="HK">Hong Kong</option>
                                <option data-tel="36" value="HU">Hungary</option>
                                <option data-tel="354" value="IS">Iceland</option>
                                <option data-tel="91" value="IN">India</option>
                                <option data-tel="62" value="ID">Indonesia</option>
                                <option data-tel="98" value="IR">Iran</option>
                                <option data-tel="964" value="IQ">Iraq</option>
                                <option data-tel="353" value="IE">Ireland</option>
                                <option data-tel="44-1624" value="IM">Isle of Man</option>
                                <option data-tel="972" value="IL">Israel</option>
                                <option data-tel="39" value="IT">Italy</option>
                                <option data-tel="225" value="CI">Ivory Coast</option>
                                <option data-tel="1-876" value="JM">Jamaica</option>
                                <option data-tel="81" value="JP">Japan</option>
                                <option data-tel="44-1534" value="JE">Jersey</option>
                                <option data-tel="962" value="JO">Jordan</option>
                                <option data-tel="7" value="KZ">Kazakhstan</option>
                                <option data-tel="254" value="KE">Kenya</option>
                                <option data-tel="686" value="KI">Kiribati</option>
                                <option data-tel="" value="XK">Kosovo</option>
                                <option data-tel="965" value="KW">Kuwait</option>
                                <option data-tel="996" value="KG">Kyrgyzstan</option>
                                <option data-tel="856" value="LA">Laos</option>
                                <option data-tel="371" value="LV">Latvia</option>
                                <option data-tel="961" value="LB">Lebanon</option>
                                <option data-tel="266" value="LS">Lesotho</option>
                                <option data-tel="231" value="LR">Liberia</option>
                                <option data-tel="218" value="LY">Libya</option>
                                <option data-tel="423" value="LI">Liechtenstein</option>
                                <option data-tel="370" value="LT">Lithuania</option>
                                <option data-tel="352" value="LU">Luxembourg</option>
                                <option data-tel="853" value="MO">Macao</option>
                                <option data-tel="389" value="MK">Macedonia</option>
                                <option data-tel="261" value="MG">Madagascar</option>
                                <option data-tel="265" value="MW">Malawi</option>
                                <option data-tel="60" value="MY">Malaysia</option>
                                <option data-tel="960" value="MV">Maldives</option>
                                <option data-tel="223" value="ML">Mali</option>
                                <option data-tel="356" value="MT">Malta</option>
                                <option data-tel="692" value="MH">Marshall Islands</option>
                                <option data-tel="596" value="MQ">Martinique</option>
                                <option data-tel="222" value="MR">Mauritania</option>
                                <option data-tel="230" value="MU">Mauritius</option>
                                <option data-tel="262" value="YT">Mayotte</option>
                                <option data-tel="52" value="MX">Mexico</option>
                                <option data-tel="691" value="FM">Micronesia</option>
                                <option data-tel="373" value="MD">Moldova</option>
                                <option data-tel="377" value="MC">Monaco</option>
                                <option data-tel="976" value="MN">Mongolia</option>
                                <option data-tel="382" value="ME">Montenegro</option>
                                <option data-tel="1-664" value="MS">Montserrat</option>
                                <option data-tel="212" value="MA">Morocco</option>
                                <option data-tel="258" value="MZ">Mozambique</option>
                                <option data-tel="95" value="MM">Myanmar</option>
                                <option data-tel="264" value="NA">Namibia</option>
                                <option data-tel="674" value="NR">Nauru</option>
                                <option data-tel="977" value="NP">Nepal</option>
                                <option data-tel="31" value="NL">Netherlands</option>
                                <option data-tel="599" value="AN">Netherlands Antilles</option>
                                <option data-tel="687" value="NC">New Caledonia</option>
                                <option data-tel="64" value="NZ">New Zealand</option>
                                <option data-tel="505" value="NI">Nicaragua</option>
                                <option data-tel="227" value="NE">Niger</option>
                                <option data-tel="234" value="NG">Nigeria</option>
                                <option data-tel="683" value="NU">Niue</option>
                                <option data-tel="672" value="NF">Norfolk Island</option>
                                <option data-tel="1-670" value="MP">Northern Mariana Islands</option>
                                <option data-tel="850" value="KP">North Korea</option>
                                <option data-tel="47" value="NO">Norway</option>
                                <option data-tel="968" value="OM">Oman</option>
                                <option data-tel="92" value="PK">Pakistan</option>
                                <option data-tel="680" value="PW">Palau</option>
                                <option data-tel="970" value="PS">Palestinian Territory</option>
                                <option data-tel="507" value="PA">Panama</option>
                                <option data-tel="675" value="PG">Papua New Guinea</option>
                                <option data-tel="595" value="PY">Paraguay</option>
                                <option data-tel="51" value="PE">Peru</option>
                                <option data-tel="63" value="PH">Philippines</option>
                                <option data-tel="870" value="PN">Pitcairn</option>
                                <option data-tel="48" value="PL">Poland</option>
                                <option data-tel="351" value="PT">Portugal</option>
                                <option data-tel="1" value="PR">Puerto Rico</option>
                                <option data-tel="974" value="QA">Qatar</option>
                                <option data-tel="242" value="CG">Republic of the Congo</option>
                                <option data-tel="262" value="RE">Reunion</option>
                                <option data-tel="40" value="RO">Romania</option>
                                <option data-tel="7" value="RU">Russia</option>
                                <option data-tel="250" value="RW">Rwanda</option>
                                <option data-tel="590" value="BL">Saint Barthelemy</option>
                                <option data-tel="290" value="SH">Saint Helena</option>
                                <option data-tel="1-869" value="KN">Saint Kitts and Nevis</option>
                                <option data-tel="1-758" value="LC">Saint Lucia</option>
                                <option data-tel="590" value="MF">Saint Martin</option>
                                <option data-tel="508" value="PM">Saint Pierre and Miquelon</option>
                                <option data-tel="1-784" value="VC">Saint Vincent and the Grenadines</option>
                                <option data-tel="685" value="WS">Samoa</option>
                                <option data-tel="378" value="SM">San Marino</option>
                                <option data-tel="239" value="ST">Sao Tome and Principe</option>
                                <option data-tel="966" value="SA">Saudi Arabia</option>
                                <option data-tel="221" value="SN">Senegal</option>
                                <option data-tel="381" value="RS">Serbia</option>
                                <option data-tel="381" value="CS">Serbia and Montenegro</option>
                                <option data-tel="248" value="SC">Seychelles</option>
                                <option data-tel="232" value="SL">Sierra Leone</option>
                                <option data-tel="65" value="SG">Singapore</option>
                                <option data-tel="599" value="SX">Sint Maarten</option>
                                <option data-tel="421" value="SK">Slovakia</option>
                                <option data-tel="386" value="SI">Slovenia</option>
                                <option data-tel="677" value="SB">Solomon Islands</option>
                                <option data-tel="252" value="SO">Somali</option>
                                <option data-tel="27" value="ZA">South Africa</option>
                                <option data-tel="" value="GS">South Georgia and the South Sandwich Islands</option>
                                <option data-tel="82" value="KR">South Korea</option>
                                <option data-tel="211" value="SS">South Sudan</option>
                                <option data-tel="34" value="ES">Spain</option>
                                <option data-tel="94" value="LK">Sri Lanka</option>
                                <option data-tel="249" value="SD">Sudan</option>
                                <option data-tel="597" value="SR">Suriname</option>
                                <option data-tel="47" value="SJ">Svalbard and Jan Mayen</option>
                                <option data-tel="268" value="SZ">Swaziland</option>
                                <option data-tel="46" value="SE">Sweden</option>
                                <option data-tel="41" value="CH">Switzerland</option>
                                <option data-tel="963" value="SY">Syria</option>
                                <option data-tel="886" value="TW">Taiwan</option>
                                <option data-tel="992" value="TJ">Tajikistan</option>
                                <option data-tel="255" value="TZ">Tanzania</option>
                                <option data-tel="66" value="TH">Thailand</option>
                                <option data-tel="228" value="TG">Togo</option>
                                <option data-tel="690" value="TK">Tokelau</option>
                                <option data-tel="676" value="TO">Tonga</option>
                                <option data-tel="1-868" value="TT">Trinidad and Tobago</option>
                                <option data-tel="216" value="TN">Tunisia</option>
                                <option data-tel="90" value="TR">Turkey</option>
                                <option data-tel="993" value="TM">Turkmenistan</option>
                                <option data-tel="1-649" value="TC">Turks and Caicos Islands</option>
                                <option data-tel="688" value="TV">Tuvalu</option>
                                <option data-tel="256" value="UG">Uganda</option>
                                <option data-tel="380" value="UA">Ukraine</option>
                                <option data-tel="971" value="AE">United Arab Emirates</option>
                                <option data-tel="44" value="GB">United Kingdom</option>
                                <option data-tel="1" value="US">United States</option>
                                <option data-tel="1" value="UM">United States Minor Outlying Islands</option>
                                <option data-tel="598" value="UY">Uruguay</option>
                                <option data-tel="1-340" value="VI">U.S. Virgin Islands</option>
                                <option data-tel="998" value="UZ">Uzbekistan</option>
                                <option data-tel="678" value="VU">Vanuatu</option>
                                <option data-tel="379" value="VA">Vatican</option>
                                <option data-tel="58" value="VE">Venezuela</option>
                                <option data-tel="84" value="VN">Vietnam</option>
                                <option data-tel="681" value="WF">Wallis and Futuna</option>
                                <option data-tel="212" value="EH">Western Sahara</option>
                                <option data-tel="967" value="YE">Yemen</option>
                                <option data-tel="260" value="ZM">Zambia</option>
                                <option data-tel="263" value="ZW">Zimbabwe</option>
                            </select>
                            @error('country')
                                <p class="errorInputMsg">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="input-wrapper @error('phone') error @enderror">
                            <input class="input" type="tel" name="phone" value="{{ old('phone') }}" placeholder=" ">
                            <span class="placeholder">Phone</span>
                            @error('phone')
                                <p class="errorInputMsg">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="input-wrapper @error('company_name') error @enderror">
                            <input class="input" type="text" name="company_name" value="{{ old('company_name') }}"
                                autocomplete="org" placeholder=" ">
                                <span class="placeholder">Company name</span>
                            @error('company_name')
                                <p class="errorInputMsg">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="input-wrapper @error('password') error @enderror">
                            <input class="input" type="password" name="password"
                                autocomplete="new-password" placeholder=" ">
                                <span class="placeholder">Password</span>
                            @error('password')
                                <p class="errorInputMsg">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="input-wrapper">
                            
                            <p>
                            <input type="checkbox" style="margin: 10px;">
                                Agree with our 
                                <a target="_blank" href="/tos">Terms &amp; conditions?</a></p>
                        </div>
                            
                        <button type="submit" class="sign-form_content-main-btn">Create Account</button>
                    
                    </form>
                    <div class="sign-form_content-reg-part">
                        <p>Already have an account?</p><a href="{{ route('login') }}">Sign in</a>
                    </div>
                    <!-- <div class="sign-form_content-bussines-acc">
                        <p>Are you interested in a </p><a href="/auth/sign-up-carrier"> carrier account?</a>
                    </div>
                    <div class="sign-form_content-agree-terms">
                        <p>By signing in or creating an account, you agree with our <a target="_blank" href="/tos">Terms
                                &amp; conditions</a></p>
                    </div> -->
                </div>
            </div>
        </div>
        <!-- <nav class="bottom-links">
            <a href="/contact" target="_blank">Contact us &amp; Feedback</a><a
                href="/contact/shippers-help " target="_blank">Help</a><a href="/privacy" target="_blank">Privacy</a>
        </nav> -->
    </section>
</div>

@endsection


@section('bottom_scripts')
<script>
    $(document).ready(function() 
    {
        $('#additional_email').hide();
        $("#role").change(function()
        {
            if($(this).find(':selected').val() == 'vendor')
            {
                $('#additional_email').show();
            }
            else if($(this).find(':selected').val() == 'user')
            {
                $('#additional_email').hide();
            }
        });
    });
</script>
@endsection
