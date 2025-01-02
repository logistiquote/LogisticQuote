<div class="wizard-inner mb-3" style="display: none">
    <div class="connecting-line"></div>
    <ul class="nav nav-tabs" role="tablist">
        @foreach ($steps as $index => $step)
            <li role="presentation" class="{{ $index === 0 ? 'active' : 'disabled' }}">
                <a href="#{{ $step['id'] }}" data-toggle="tab" aria-controls="{{ $step['id'] }}" role="tab">
                    <div class="tab-content-container">
                        <span class="tab-title">{{ $step['title'] }}</span>
                        <span class="round-tab">{{ $index + 1 }}</span>
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
</div>

<style>
    .wizard .nav-tabs {
        position: relative;
        margin-bottom: 0;
        border-bottom-color: transparent;
        display: flex;
        justify-content: space-between;
        text-align: center;
        padding: 0;
    }

    .wizard .nav-tabs>li {
        flex: 1;
        position: relative;
    }

    .wizard .nav-tabs>li a {
        text-decoration: none;
        color: inherit;
    }

    .wizard .tab-content-container {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
    }

    .wizard .tab-title {
        margin-bottom: 8px;
        font-size: 12px;
        font-weight: bold;
        color: #555;
        white-space: nowrap;
    }

    .wizard .round-tab {
        width: 30px;
        height: 30px;
        line-height: 30px;
        border-radius: 50%;
        display: inline-block;
        font-size: 14px;
        font-weight: bold;
        text-align: center;
        z-index: 2;
        position: relative;
    }

    .wizard .connecting-line {
        height: 2px;
        background: #e0e0e0;
        position: absolute;
        width: 75%;
        margin: 0 auto;
        left: 0;
        right: 0;
        top: 40px;
        z-index: 1;
    }

    .wizard li.active span.tab-title {
        color: #007bff;
    }

    .wizard li.active span.round-tab {
        background: #007bff;
        color: #fff;
        border-color: #007bff;
    }

    @media (max-width: 767px) {
        .wizard .nav-tabs {
            align-items: center;
        }

        .wizard .tab-title {
            display: none;
        }

        .wizard .nav-tabs>li {
            margin-bottom: 20px;
        }

        .wizard .connecting-line {
            top: 15px;
        }
    }

</style>

