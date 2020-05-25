<template>
    <footer>
        <div class="footer-inner">
            <div class="container" 
                style="padding-left: 12px; padding-right: 12px;"
            >
                <div class="row">
                    <div class="main col-lg-7 col-lg-pull-6 col-xs-12">
                        <p>Copyright © {{ new Date().getFullYear() }}, 
                            lukrativ.io. lukrativ logo is a proprietary 
                            trademark of Flora Shaw Services.
                        </p>
                    </div>
                    <div class="mobile col-lg-7 col-lg-pull-6 col-xs-12">
                        <p>Copyright © {{ new Date().getFullYear() }}, 
                            lukrativ.io.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
    export default {
        
    }
</script>

<style scoped>
    .footer-inner {
        background: #fbfcfd;
        border-top: 2px solid #f5f5f5;
    }
    .footer-inner p {
        position: relative;
        top: 7px;
        color: #6c757d;
        font-weight: 500;
        line-height: 2;
        justify-content: center;
        display: grid;
    }
    .row {
        justify-content: center;
    }
    .mobile {
        display: none;
    }

    @media screen and (max-width: 968px) {
        .mobile {
            display: block;
        }
        .main {
            display: none;
        }
    }
</style>