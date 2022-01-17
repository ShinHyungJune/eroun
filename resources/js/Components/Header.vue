<template>
    <header class="header">
        <div class="black"></div>

        <div class="wrap">
            <Link href="/" class="logo" :data="{show: false}">
                <img src="/img/logo.png" alt="" class="color">
                <img src="/img/logo-white.png" alt="" class="incolor">
            </Link>


            <div class="right">
                <nav class="navs">
                    <div class="nav">
                        <Link href="/" class="text" :data="{show: false}">HOME</Link>
                    </div>

                    <div class="nav">
                        <Link href="/requests" class="text">섭외요청</Link>
                    </div>

                    <!--
                    <div class="nav">
                        <Link href="/events" class="text">행사/이벤트</Link>
                    </div>-->

<!--
                    <div class="nav" v-if="user && user.data.worker">
                        <Link href="/events?worker=1" class="text">협력소상공인</Link>
                    </div>
-->

                    <div class="nav">
                        <Link href="/commonUsers" class="text">협력소상공인</Link>
                    </div>

                    <div class="nav">
                        <Link href="/workers" class="text">전문가</Link>
                    </div>

                    <div class="nav">
                        <Link href="/users/edit" class="text">마이페이지</Link>
                    </div>

                    <div class="nav">
                        <Link href="/login" class="text" v-if="!user">
                            <img src="/img/user.png" alt="" class="color">
                            <img src="/img/user-white.png" alt="" class="incolor">
                            로그인
                        </Link>
                        <a href="/logout" class="text" v-else>
                            <img src="/img/user.png" alt="" class="color">
                            <img src="/img/user-white.png" alt="" class="incolor">
                            로그아웃
                        </a>
                    </div>
                </nav>
            </div>

            <button class="btn-menu"></button>
        </div>

    </header>
</template>
<script>
import {Link} from '@inertiajs/inertia-vue';
export default {
    components: {Link},
    data(){
        return {
            user: this.$page.props.user
        }
    },
    methods: {

    },
    mounted() {

    }
}
</script>
