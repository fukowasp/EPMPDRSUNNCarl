    <style>
        html,
        body {
            height: 100%;
            overflow: hidden;
        }

        body {
            font-family: 'Nunito', sans-serif;
        }

        /* Height fix for mobile browsers */
        .login-wrapper {
            min-height: calc(100vh - 70px);
            padding-top: 90px;
        }

        .bg-login {
            background: #f8f9fc;
        }

        .brand-logo {
            height: 38px;
            width: auto;
            cursor: pointer;
        }

        .brand-text {
            line-height: 1.2;
        }

        .brand-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: #343a40;
        }

        .brand-subtitle {
            font-size: 0.75rem;
            font-weight: 500;
            color: #6c757d;
            letter-spacing: 0.05em;
        }

        .login-msg {
            letter-spacing: 0.1em;
        }

        /* .brand-logo {
            max-height: 80px;
        } */

        .form-control-user {
            padding-left: 2.75rem;
        }

        .brand-text {
            letter-spacing: 0.1em;
        }

        .input-icon {
            position: absolute;
            top: 75%;
            left: 1rem;
            transform: translateY(-50%);
            color: #b7b9cc;
        }

        #togglePassword {
            position: absolute;
            top: 75%;
            right: 1rem;
            transform: translateY(-50%);
            cursor: pointer;
            color: #b7b9cc;
        }

        @media (max-width: 576px) {
            .brand-logo {
                height: 36px;
            }

            .brand-title {
                font-size: 0.85rem;
                line-height: 1.2;
            }
        }
    </style>