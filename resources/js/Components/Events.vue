<template>
    <div class="items type02">
        <div class="item-wrap" v-for="item in items" :key="item.id">
            <Link :href="`/events/${item.id}`" class="item">
                <div class="m-ratioBox-wrap">
                    <div class="m-ratioBox">
                        <img :src="item.img ? item.img.url : ''" alt="">
                    </div>
                </div>

                <div class="content">
                    <h3 class="title">{{item.title}}</h3>
                    <p class="sub">{{item.created_at}}</p>
                </div>
            </Link>
        </div>
    </div>
</template>
<script>
    import {Link} from "@inertiajs/inertia-vue";

    export default {
        components: {Link},

        props: ["items"]
    }
</script>
