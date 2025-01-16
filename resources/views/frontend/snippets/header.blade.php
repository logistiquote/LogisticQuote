<header>
    <nav class="navbar">
        <div class="container-lg">
            <ul class="navRoot">
                <li class="navSection logo">
                    <a href="{{ route('index') }}" class="navbar-brand adapt-logo-desktop" data-dropdown="admin"></a>
                </li>

                <li class="navSection primary">
                    <a href="{{ route('index') }}" class="navbar-brand adapt-logo-mobile" data-dropdown="admin"></a>

                    <a class="rootLink colorize"
                       href="https://iccwbo.org/publication/incoterms-2020-practical-free-wallchart" target="_blank">
                        Incoterms
                    </a>

                    <a class="rootLink hasDropdown colorize" data-dropdown="ports">
                        Ports
                    </a>

                    <a class="rootLink colorize"
                       href="https://shaarolami-query.customs.mof.gov.il/CustomspilotWeb/he/CustomsBook"
                       target="_blank">
                        Taxes and duties
                    </a>

                    <a class="rootLink hasDropdown colorize" data-dropdown="company">
                        Company
                    </a>
                    <a class="rootLink colorize" href="#" target="_blank">
                        Terms
                    </a>
                    <span class="navSection secondary">
                         @guest
                            <a class="rootLink item-dashboard colorize" href="{{ route('login') }}">Sign in </a>
                        @else
                            <div id="nav-prof">
                            <a class="dropdown-toggle rootLink colorize" href="javascript:" data-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-closer">
                                <li class="clearfix dropdown-header dropdown-stop">
                                    <div class="user-mini-pic">
                                        <img src="{{ asset('uploads/profile_pic/avatar.png') }}" alt="logo">
                                    </div>
                                    <div class="user-info">
                                        <div class="user-name"> {{ Auth::user()->name }} </div>
                                        <div class="user-company">{{ Auth::user()->role }}</div>
                                        <div class="user-id">Profile ID: {{ Auth::user()->id }}</div>
                                    </div>
                                </li>

                                <li>
                                    <a href="{{ route('user') }}">
                                        <i class="fad fa-tachometer-alt-fast"></i>
                                        Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fad fa-sign-out"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                        @endguest
                    </span>
                </li>

                <!-- Mobile navbar -->
                <li class="navSection mobile">
                    <a class="rootLink item-mobileMenu colorize">
                        <h2>Menu</h2>
                    </a>

                    <div class="popup">
                        <div class="popupContainer">
                            <a
                                class="collapsible"
                                href="https://iccwbo.org/publication/incoterms-2020-practical-free-wallchart"
                                target="_blank"
                            >
                                Incoterms
                            </a>
                            <div class="mobileProducts">
                                <a class="collapsible" href="#">Ports</a>
                                <div class="collapse">
                                    <a class="linkContainer item-payments ports-mobile"
                                       href="https://www.ashdodport.co.il/pages/default.aspx" target="_blank">
                                        <i class="fab fa-usps fa-2x"></i>
                                        <div>
                                            <h3 class="linkTitle">Ashdod Port</h3>
                                            <p class="linkSub">About 40 kilometers south of Tel Aviv</p>
                                        </div>
                                    </a>
                                    <a class="linkContainer item-payments ports-mobile" href="https://www.haifaport.co.il/"
                                       target="_blank">
                                        <i class="fas fa-pallet fa-2x"></i>
                                        <div>
                                            <h3 class="linkTitle">Haifa Port</h3>
                                            <p class="linkSub">'Israel's leading Cruise Terminal and the only turnaround
                                                terminal in Israel</p>
                                        </div>
                                    </a>
                                    <a class="linkContainer item-payments ports-mobile" href="https://www.maman.co.il/he/3-1-3.asp"
                                       target="_blank">
                                        <i class="far fa-torii-gate fa-2x"></i>
                                        <div>
                                            <h3 class="linkTitle">Maman</h3>
                                            <p class="linkSub">It is a full-service logistics supplier</p>
                                        </div>
                                    </a>
                                    <a class="linkContainer item-payments ports-mobile" href="https://www.swissport.co.il/heb/Main/"
                                       target="_blank">
                                        <i class="fab fa-cotton-bureau fa-2x"></i>
                                        <div>
                                            <h3 class="linkTitle">Swissport</h3>
                                            <p class="linkSub">Swissport International Ltd. is an aviation services
                                                company</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <a class="collapsible"
                               href="https://shaarolami-query.customs.mof.gov.il/CustomspilotWeb/he/CustomsBook"
                               target="_blank">
                                Taxes and duties
                            </a>
                            <a class="collapsible" href="{{ route('contact_us') }}" target="_blank">
                                Company
                            </a>
                            <a class="collapsible" href="#" target="_blank">
                                Terms
                            </a>
                        </div>
                    </div>
                </li>
                <!-- Mobile navbar -->
            </ul>
        </div>
        <div class="dropdownRoot">
            <div class="dropdownBackground" style="background-color:#FFF4E5;transform: translateX(452px) scaleX(0.707692) scaleY(1.1075);">
                <div class="alternateBackground" style="transform: translateY(255.53px);"></div>
            </div>

            <div class="dropdownArrow" style="transform: translateX(636px) rotate(45deg);"></div>

            <div class="dropdownContainer" style="transform: translateX(452px); width: 368px; height: 443px;">

                <div class="dropdownSection left" data-dropdown="ports">
                    <div class="dropdownContent">
                        <div class="linkGroup">
                            <ul class="productsGroup">
                                <li>
                                    <a class="linkContainer item-payments"
                                       href="https://www.ashdodport.co.il/pages/default.aspx" target="_blank">
                                        <i class="fab fa-usps fa-2x"></i>
                                        <div class="productLinkContent">
                                            <h3 class="linkTitle">Ashdod Port</h3>
                                            <p class="linkSub">About 40 kilometers south of Tel Aviv</p>
                                        </div>
                                    </a>
                                </li>

                                <li>
                                    <a class="linkContainer item-payments" href="https://www.haifaport.co.il/"
                                       target="_blank">
                                        <i class="fas fa-pallet fa-2x"></i>
                                        <div class="productLinkContent">
                                            <h3 class="linkTitle">Haifa Port</h3>
                                            <p class="linkSub">'Israel's leading Cruise Terminal and the only turnaround
                                                terminal in Israel</p>
                                        </div>
                                    </a>
                                </li>

                                <li>
                                    <a class="linkContainer item-payments" href="https://www.maman.co.il/he/3-1-3.asp"
                                       target="_blank">
                                        <i class="far fa-torii-gate fa-2x"></i>
                                        <div class="productLinkContent">
                                            <h3 class="linkTitle">Maman</h3>
                                            <p class="linkSub">It is a full-service logistics supplier</p>
                                        </div>
                                    </a>
                                </li>

                                <li>
                                    <a class="linkContainer item-payments" href="https://www.swissport.co.il/heb/Main/"
                                       target="_blank">
                                        <i class="fab fa-cotton-bureau fa-2x"></i>
                                        <div class="productLinkContent">
                                            <h3 class="linkTitle">Swissport</h3>
                                            <p class="linkSub">Swissport International Ltd. is an aviation services
                                                company</p>
                                        </div>
                                    </a>
                                </li>

                            </ul>
                        </div>

                    </div>
                </div>


                <div class="dropdownSection right" data-dropdown="company">
                    <div class="dropdownContent">
                        <div class="linkGroup blogGroup">

                            <a class="linkContainer withIcon item-documentation" href="{{ route('contact_us') }}">
                                <h3 class="linkTitle linkIcon"><i class="fad fa-phone"></i> Contact us </h3>
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div id="message_container"></div>
</header>
