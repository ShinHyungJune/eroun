<template>
    <div class="items type01">
        <div class="item-wrap" v-for="item in items" :key="item.id">
            <Link :href="`/items/${item.id}`" class="item">
                <div class="m-ratioBox-wrap">
                    <div class="m-ratioBox">
                        <img :src="item.img ? item.img.url : ''" alt="">
                    </div>
                </div>

                <p class="category">
                    <span class="text" v-for="category in item.categories.data" :key="category.id">{{category.title}}</span>
                </p>
                <div class="bottom">
                    <h3 class="title">{{item.name}}</h3>

                    <p class="point">
                        <img src="/img/star-primary.png" alt="">
                        {{item.score ? item.score : '-'}}
                    </p>
                </div>
            </Link>
        </div>
    </div>
</template>
<script>
    export default {
        props: ["items"]
    }
</script>
