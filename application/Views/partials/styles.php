<style>
    body {
        background: #eaeaea;
    }

    body.darkmode {
        background: #222 !important;
    }

    .dataTables_length, .dataTables_filter { display: none; }

    .darkmode .card {
        background-color: #999 !important;
        color: #fff;
        border-color: #303030 !important;
    }

    .darkmode .text-muted {
        color: #222 !important;
    }

    .darkmode .card .card-header {
        padding: 0.75rem 1.25rem;
        margin-bottom: 0;
        background-color: #444;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        color: #fff;
    }

    .darkmode .footer {
        color: #fff;
    }

    #logo-lavazza-extended {
        height: 8.5vh;
        fill: #0a2d4b;
    }

    .darkmode #logo-lavazza-extended {
        fill: rgba(255,255,255,.5);
    }

    svg text {
        -webkit-user-select: none; /* Safari */
        -moz-user-select: none; /* Firefox */
        -ms-user-select: none; /* IE10+/Edge */
        user-select: none; /* Standard */
    }

    .form-switch i {
        position: relative;
        display: inline-block;
        margin-right: .5rem;
        width: 46px;
        height: 26px;
        background-color: #e6e6e6;
        border-radius: 23px;
        vertical-align: text-bottom;
        transition: all 0.3s linear;
        cursor: pointer;
    }

    .form-switch i::before {
        content: "";
        position: absolute;
        left: 0;
        width: 42px;
        height: 22px;
        background-color: #fff;
        border-radius: 11px;
        transform: translate3d(2px, 2px, 0) scale3d(1, 1, 1);
        transition: all 0.25s linear;
    }

    .form-switch i::after {
        content: "";
        position: absolute;
        left: 0;
        width: 22px;
        height: 22px;
        background-color: #fff;
        border-radius: 11px;
        box-shadow: 0 2px 2px rgba(0, 0, 0, 0.24);
        transform: translate3d(2px, 2px, 0);
        transition: all 0.2s ease-in-out;
    }

    .form-switch:active i::after {
        width: 28px;
        transform: translate3d(2px, 2px, 0);
    }

    .form-switch:active input:checked + i::after { transform: translate3d(16px, 2px, 0); }

    .form-switch input { display: none; }

    .form-switch input:checked + i { background-color: #0a2d4b; }

    .form-switch input:checked + i::before { transform: translate3d(18px, 2px, 0) scale3d(0, 0, 0); }

    .form-switch input:checked + i::after { transform: translate3d(22px, 2px, 0); }
</style>