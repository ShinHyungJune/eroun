<template>
    <footer class="footer" v-if="information">
        <div class="wrap">
            <img src="/img/logo.png" alt="" class="logo">

            <div class="box-infos">
                <div class="infos">
                    <p class="info">{{ information.name_company }}</p>
                    <p class="info">대표 {{information.name_president}}</p>
                    <p class="info">{{ information.number_company }}</p>
                    <p class="info">Tel. {{information.contact}}</p>
                </div>
                <div class="infos">
                    <p class="info">개인정보관리책임자 {{information.charger_privacy}}</p>
                </div>

                <p class="copyright">Copyright@2021 by {{information.name_company}} Corporation ALL RIGHT RESERVED.</p>
            </div>

            <div class="right">
                <a :href="information.file ? information.file.url : ''" class="btn">
                    회사 소개서 <img src="/img/download-primary.png" alt="">
                </a>

                <div class="socials">
                    <a :href="information.facebook" target="_blank" class="social" v-if="information.facebook">
                        <img src="/img/circleFacebook.png" alt="">
                    </a>
                    <a :href="information.instagram" target="_blank" class="social" v-if="information.instagram">
                        <img src="/img/circleInsta.png" alt="">
                    </a>
                    <a :href="information.kakao" target="_blank" class="social" v-if="information.kakao">
                        <img src="/img/circleKakao.png" alt="">
                    </a>
                    <a :href="information.youtube" target="_blank" class="social" v-if="information.youtube">
                        <img src="/img/circleYoutube.png" alt="">
                    </a>
                </div>
            </div>



        </div>
    </footer>
</template>
<script>
import {Link} from '@inertiajs/inertia-vue';
export default {
    components: {Link},
    data(){
        return {
            information : this.$page.props.information.data
        }
    },
}
</script>
