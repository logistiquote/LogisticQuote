@extends('frontend.layouts.app')
@section('content')


<div class="main-content">

    <div class="wrapper-home-pages">
        <section class="wrapper-header-block">
            <div class="header-block">
                <div class="header-block-top">
                    <h1 class="text-animation title-shipping active"> <span>Find the best Freight Quote For You</span>
                    </h1>
                    <h2 class="text-animation title-tracking"><span>Track a shipment</span> </h2>
                    <canvas id="bubbles-canvas"></canvas>
                    <div class="header-block-top-content">
                        <div class="container header-title">
                            <div class="title-shipping active">
                                <p>Shipping to and from anywhere</p>
                            </div>
                            <div class="title-tracking">
                                <p>Check shipment delivery status online</p>
                            </div>
                        </div>
                        <div class="main-filter-wrapper">
                            <div class="wrapper-main-filter">
                                <div class="wrapper-application-switch">
                                    <div class="application-switch">
                                        <ul>
                                            <li class="switch-freight active">Freight Quotes</li>
                                            <li class="switch-tracking ">Container Tracking</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="wrapper-filter-block">
                                    <div class="filter-block">
                                        <div class="wrapper-form">
                                            <form class="filter-shipping active" method="POST" action="{{ route('get_quote_step1') }}" autocomplete="off">
                                                @csrf

                                                <div class="wrapper-box-shadow">
                                                    <div class="route-item"> <span class="top-title">VIA</span>
                                                        <ul class="route-list">
                                                            <li>
                                                                <a data-mode="sea" class="btn-route route-active"
                                                                    title="Transit type: Ocean freight">
                                                                    <i class="fad fa-ship"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a data-mode="air" class="btn-route"
                                                                    title="Transit type: Airfreigh">
                                                                    <i class="far fa-plane-departure"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        <input type="hidden" id="transportation_type" name="transportation_type" value="sea" required>
                                                    </div>

                                                    <div class="shipping-directions">
                                                        <div class="input-icon">
                                                            <span class="top-title">ORIGIN OF SHIPMENT</span>
                                                            <input type="text" placeholder="Port, Country, City, Zip"
                                                                value="" name="origin" id="addr_from" autocomplete="off" required>
                                                        </div>

                                                        <div class="input-icon">
                                                            <span class="top-title">DESTINATION OF SHIPMENT</span>
                                                            
                                                            <input type="text" placeholder="Port, Country, City, Zip"
                                                                value="" name="destination" id="addr_to" autocomplete="off" required>
                                                        </div>
                                                    </div>

                                                    <div class="date-field">
                                                        <div class="date-block">
                                                            <span class="top-title">Ready to load</span>
                                                            <input class="date-day" name="date" type="text"
                                                                data-date-format="dd-mm-yyyy" autocomplete="off"
                                                                readonly required id="ready_to_load_date"> 
                                                        </div>
                                                    </div>

                                                    <div class="dropdown-shipment" id="dropdown-shipment">
                                                        <span class="top-title">Type of shipment</span>
                                                        <a class="dropdown-toggle" data-toggle="dropdown"
                                                            href="javascript:;">
                                                            <i class="fad fa-truck-container"></i> FCL
                                                            <i class="fal fa-angle-down"></i>
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a data-mode="sea" data-type="fcl" href="javascript:;">
                                                                    <i class="fad fa-truck-container"></i> <span>FCL</span>
                                                                </a>
                                                                <span class="transcript">FULL CONTAINER LOAD</span>
                                                            </li>
                                                            <li>
                                                                <a data-mode="sea" data-type="lcl" href="javascript:;">
                                                                    <i class="fad fa-truck-loading"></i><span>LCL</span>
                                                                </a>
                                                                <span class="transcript">LESS CONTAINER LOAD</span>
                                                            </li>

                                                            <li>
                                                                <a data-mode="air" data-type="air" href="javascript:;">
                                                                    <i class="fad fa-plane"></i><span>AIR</span>
                                                                </a>
                                                                <span class="transcript">AIR DELIVERY</span>
                                                            </li>
                                                        </ul>
                                                    </div> 
                                                    <input type="hidden" name="type" value="fcl">
                                                </div>

                                                <div class="route-btn">
                                                    <button type="submit" id="btn-search-shipping">Quote</button>
                                                </div>
                                            </form>
                                        </div>
                                        
                                        <div class="wrapper-form">
                                            <form class="filter-tracking" method="GET"
                                                action="https://touch.track-trace.com/container" target="_blank">
                                                <div class="wrapper-box-shadow">
                                                    <div class="container-number"> 
                                                        <span class="top-title">TRACKING
                                                            NUMBER</span> 
                                                            <input pattern="[A-Za-z0-9\-]{5,}"
                                                            title="Container number or code" type="text"
                                                            name="container" placeholder="Container Number/Code"
                                                            autocomplete="off"> </div>
                                                    <div class="select-wrapper"> <span class="top-title">SELECT
                                                            SEALINE</span> <select name="sealine" id="select-two"
                                                            >
                                                            <option value="0">Auto Detect</option>
                                                            <option value="14">APL</option>
                                                            <option value="2">ARKAS</option>
                                                            <option value="15">CMA CGM</option>
                                                            <option value="5">COSCO</option>
                                                            <option value="6">EVERGREEN</option>
                                                            <option value="4">HAMBURG SUD</option>
                                                            <option value="7">HAPAG-LLOYD</option>
                                                            <option value="104">HYUNDAI</option>
                                                            <option value="10">MAERSK</option>
                                                            <option value="1">MSC</option>
                                                            <option value="88">ONE</option>
                                                            <option value="17">OOCL</option>
                                                            <option value="111">SAFMARINE</option>
                                                            <option value="112">SEALAND</option>
                                                            <option value="124">SINOKOR</option>
                                                            <option value="69">TURKON</option>
                                                            <option value="97">WAN HAI</option>
                                                            <option value="18">YANG MING</option>
                                                            <option value="13">ZIM</option>
                                                        </select> </div>
                                                </div>
                                                <div class="route-btn"> <button type="submit">Search</button> </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script>
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        
        <section class="wrapper-vo">
            <div class="wrapper-container">
                <h2>Section I</h2>
                <div class="section-block">
                    <div class="img-block"> 
                        <img
                            src="{{ asset('public/frontend/images/homepage/1.jpg') }}"
                            class="background" alt="profile">

                    </div>
                    <div class="content">
                        <h3>Organize!</h3>
                        <p>It takes chaos to value peace.</p>
                        <div class="button-block"> <a href="#" class="link">Button</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="wrapper-freight-marketplace">
            <h2>Section II</h2>
            <p>sub-lines</p>
            <div class="wrapper-container">
                <div class="section-block-columns">
                    <div class="content">
                        <ul class="list">
                            <li class="item">
                                <h4>H1</h4>
                                <p>What I say: let's evolve, let the chips fall where they may.</p>
                            </li>
                            <li class="item">
                                <h4>H2</h4>
                                <p>Bella Chao.</p>
                            </li>
                            <li class="item">
                                <h4>H3</h4>
                                <p>Lorem Ipsum.</p>
                            </li>
                        </ul>
                        <div class="button-block"> <a href="shipping/for-shippers/index.html" class="link"> Explore </a> </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="wrapper-benefits-block">
            <div class="benefits-wrapper">
                <div class="benefits-bubbles">
                    <h2>Why <span>LogistiQuote</span></h2>
                    <div class="benefits">
                        <div class="item">
                            <div class="ico"> 
                                <i class="fad fa-circle fa-2x"></i>
                            </div>
                            <div class="content">
                                <h3>Benifit 1</h3>
                                <p>It is good!</p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="ico"> 
                                <img src="#" alt=""> </div>
                            <div class="content">
                                <h3>Benifit 2</h3>
                                <p>It is still good.</p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="ico"> 
                                <i class="fad fa-circle fa-2x"></i>
                             </div>
                            <div class="content">
                                <h3>Benifit 3</h3>
                                <p>It can be good, depends upon the eyes of beholder.</p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="ico"> <img src="{{ asset('public/frontend/images/index/icons/ben-ico5.svg') }}"
                                    alt=""> </div>
                            <div class="content">
                                <h3>Benifit 4</h3>
                                <p>Everything is subjective.</p>
                            </div>
                        </div>
                    </div>
                    <div class="benefits-arrow"></div>
                </div>
            </div>
        </section>

        <div class="wrapper-cookies">
            <div class="cookies"> <span class="cookies-text"> By using this website, you agree to <a target="_blank"
                        href="#">our privacy policy</a> </span>
                <div class="cookies-button"> <a>OK</a> </div>
            </div>
        </div>

    </div>
    
</div>

@endsection
