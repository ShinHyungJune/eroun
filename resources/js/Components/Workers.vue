<template>
    <div class="items type01">
        <div class="item-wrap" v-for="item in items" :key="item.id">
            <Link :href="item.worker ? `/workers/${item.id}` : `/commonUsers/${item.id}`" class="item">
                <div class="m-ratioBox-wrap">
                    <div class="m-ratioBox">
                        <img :src="item.img ? item.img.url : ''" alt="">
                    </div>
                </div>

                <p class="category">
                    <span class="text" v-for="category in item.categories" :key="category.id">{{category.title}}</span>

                    <span class="tag" v-if="item.educated">교육수료</span>
                </p>
                <div class="bottom">

                    <h3 class="title">{{item.name}}</h3>

                    <p class="point" v-if="item.worker">
                        <img src="/img/star-primary.png" alt="">
                        {{item.score ? item.score : '리뷰없음'}}
                    </p>
                </div>
            </Link>
        </div>
    </div>
</template>
<script>
    import {Link} from '@inertiajs/inertia-vue';

    export default {
        components: {Link},
        props: ["items"],
    }
</script>
