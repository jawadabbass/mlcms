    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 100px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .switch .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ca2222;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .switch .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .switch input:checked+.slider {
            background-color: #2ab934;
        }

        .switch input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        .switch input:checked+.slider:before {
            -webkit-transform: translateX(55px);
            -ms-transform: translateX(55px);
            transform: translateX(55px);
            left: 15px;
        }

        /*------ ADDED CSS ---------*/
        .switch .on {
            display: none;
        }

        .switch .on,
        .switch .off {
            color: white;
            position: absolute;
            transform: translate(-50%, -50%);
            top: 50%;
            left: 50%;
            font-size: 10px;
            font-family: Verdana, sans-serif;
        }

        .switch input:checked+.slider .on {
            display: block;
        }

        .switch input:checked+.slider .off {
            display: none;
        }

        /*--------- END --------*/
        /* Rounded sliders */
        .switch .slider.round {
            border-radius: 34px;
        }

        .switch .slider.round:before {
            border-radius: 50%;
        }
    </style>
