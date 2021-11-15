<template>
    <header class="header">
        <div class="black"></div>

        <div class="wrap">
            <Link href="/" class="logo">
                <img src="/img/logo.png" alt="">
            </Link>


            <div class="right">
                <nav class="navs">
                    <div class="nav">
                        <Link href="/users/edit" class="text">마이페이지</Link>
                    </div>

                    <div class="nav">
                        <Link href="/requests" class="text">문의내역</Link>
                    </div>

                    <div class="nav">
                        <Link href="/events" class="text">행사/이벤트</Link>
                    </div>

                    <div class="nav">
                        <Link href="/workers" class="text">전문가</Link>
                    </div>

                    <div class="nav">
                        <Link href="/login" class="text" v-if="!user">
                            <img src="/img/user.png" alt="">
                            로그인
                        </Link>
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
