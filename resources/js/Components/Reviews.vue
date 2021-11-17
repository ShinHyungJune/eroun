<template>
    <div class="reviews type01">
        <div class="review" v-for="item in items" :key="item.id">
            <p class="body">
                {{item.description}}
            </p>
            <div class="bottom">
                <div class="left">
                    <p class="score">
                        <img src="/img/star-primary.png" alt="">
                        {{item.score}}
                    </p>
                    <p class="writer">{{ item.user.name }}</p>
                </div>

                <div class="right">
                    {{ item.created_at }}
                </div>
            </div>
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
