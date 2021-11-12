<template>
    <footer class="footer">
        <div class="banner">
            <div class="wrap">
                <div class="box-text">
                    <h3 class="title">Enroll in an K-12 Learning Program Now</h3>
                    <p class="body">Enroll in one of our many K-12 education programs now and start learning at your own pace immediately!</p>
                </div>

                <img src="/img/building.png" alt="" class="img">
            </div>
        </div>

        <div class="top">
            <div class="wrap">
                <div class="links">
                    <Link href="/" class="link">Home</Link>
                    <Link href="/policy/termsOfUse" class="link">Terms of use</Link>
                    <a href="/policy/privacyPolicy" class="link">Privacy Policy</a>
                    <a href="/policy/legalNotice" class="link">Legal Notice</a>
                    <a href="/policy/copyRight" class="link">Copyright</a>
                </div>

                <div class="socials">
                    <!--
                    <a href="#" target="_blank" class="social">
                        <img src="/img/facebook.png" alt="">
                    </a>

                    <a href="#" target="_blank" class="social">
                        <img src="/img/pinterest.png" alt="">
                    </a>

                    <a href="#" target="_blank" class="social">
                        <img src="/img/twitter.png" alt="">
                    </a>

                    <a href="#" target="_blank" class="social">
                        <img src="/img/instagram.png" alt="">
                    </a>
                    -->

                    <a href="https://www.youtube.com/channel/UCb5PESlZtsKc3QRbblt-lMQ" target="_blank" class="social">
                        <img src="/img/youtube.png" alt="">
                    </a>
                </div>
            </div>
        </div>

        <div class="bottom">
            <div class="wrap">
                <div class="boxes">
                    <div class="box-wrap">
                        <div class="box">
                            <img src="/img/logo-white.png" alt="" class="logo">

                            <p class="body">
                                We enrich lives, create futures, and make
                                <br/>online learning better every day!
                            </p>
                        </div>
                    </div>

                    <div class="box-wrap">
                        <div class="box">
                            <h3 class="title">Contact us</h3>

                            <p class="body">
                                3960 Howard Hughes Parkway, Suite 500,
                                <br/>Las Vegas, NV, 89169, USA
                            </p>

                            <p class="body">support@wharton.education</p>

                            <p class="body">US Office: 1-702-9903555</p>

                            <p class="body">Cell #: 1-909-5398260</p>

                            <p class="body">Fax: 1-702-9903501 </p>
                        </div>
                    </div>

                    <div class="box-wrap">
                        <div class="box">
                            <h3 class="title">Quick Links</h3>
                            <Link href="/admission/admissions" class="body link">Admissions</Link>
                            <Link href="/academics/highSchool" class="body link">Courses</Link>
                            <Link href="/tuition/tuition" class="body link">Tuition</Link>
                            <Link href="/whoWeAre/contactUs" class="body link">Contact us</Link>
                            <Link href="/enrollNow/enrollNow" class="body link">Enroll now</Link>
                            <Link href="/login" class="body link">Student login</Link>
                        </div>
                    </div>

                    <div class="box-wrap">
                        <div class="box">
                            <h3 class="title">Tools</h3>
                            <a href="https://www.adobe.com/en/acrobat/pdf-reader.html" target="_blank" class="body link">Acrobat Reader</a>
                            <a href="https://support.microsoft.com/en-us/topic/supported-versions-of-the-office-viewers-a2a766fe-06bb-b0d7-2a55-e200d9ccad6f" target="_blank" class="body link">MS Office Viewers</a>
                            <a href="https://translate.google.co.kr/?hl=en" target="_blank" class="body link">Google Translate</a>
                            <a href="https://chrome.google.com/webstore/detail/screen-reader/kgejglhpjiefppelpmljglcjbhoiplfn" target="_blank" class="body link">Screen Reader</a>
                        </div>
                    </div>
                </div>

                <p class="copyright">Copyright © 2021 World Cultures and Languages Institute, Inc. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
</template>
<script>
import {Link} from '@inertiajs/inertia-vue';
export default {
    components: {Link}
}
</script>
