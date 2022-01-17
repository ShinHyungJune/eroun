<template>
    <div class="subContent area-login">
        <div class="wrap">
            <div class="section-title type01">
                <h3 class="title">로그인</h3>
                <p class="body">SNS 계정으로 쉽게 가입 및 로그인하세요.</p>
            </div>

            <form action="" class="form type02" @submit.prevent="login">
                <div class="m-input-wrap type01">
                    <div class="m-input-text type01">
                        <input type="text" placeholder="폰번호 아이디(- 없이)" v-model="form.contact">
                    </div>

                    <div class="m-input-error">{{form.errors.contact}}</div>
                </div>


                <div class="m-input-wrap type01">
                    <div class="m-input-text type01">
                        <input type="password" placeholder="비밀번호" v-model="form.password">
                    </div>

                    <div class="m-input-error">{{form.errors.password}}</div>
                </div>

                <div class="btns">
                    <button class="btn bg-primary" style="color:#fff;">
                        로그인
                    </button>

                    <div class="links">
                        <a href="/users/create" class="link pc">
                            회원가입
                        </a>
                    </div>
                </div>

                <div class="box-divide">
                    <p class="divide">소셜 로그인</p>
                </div>

                <div class="btns">
                    <a href="/openLoginPop/kakao" class="btn kakao">
                        <img src="/img/circleBigKakao.png" alt="">
                        카카오 간편로그인
                    </a>
                    <a href="/openLoginPop/naver" class="btn naver">
                        <img src="/img/circleBigNaver.png" alt="">
                        네이버 간편로그인
                    </a>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
import Link from '@inertiajs/inertia-vue';
export default {
    components: {Link},
    data(){
        return {
            form: this.$inertia.form({
                contact:"",
                password:""
            })
        }
    },

    methods: {
        login() {
            this.form.post("/login", {
                preserveState: false
            })
        }
    }
}
</script>
