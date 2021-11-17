<template>
    <div class="subContent area-login">
        <div class="wrap">
            <div class="section-title type01">
                <h3 class="title">로그인</h3>
                <p class="body">SNS 계정으로 쉽게 가입 및 로그인하세요.</p>
            </div>

            <form action="" class="form type02">
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

export default {
    methods: {
        login() {
            this.form.post("/login")
        }
    }
}
</script>
