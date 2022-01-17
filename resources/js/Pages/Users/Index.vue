<template>
    <div class="subContent area-workerList">
        <div class="wrap">
            <div class="section-title type01">
                <h3 class="title">협력소상공인 목록</h3>
                <p class="body">다양한 업체들을 만나보세요!</p>
            </div>

            <div class="m-input-top type01">
                <div class="count">
                    총 <span class="primary">{{ users.meta.total }}</span>명
                </div>

                <div class="inputs">
                    <div class="m-input-select type01">
                        <select name="" id="" v-model.lazy="form.orderBy" @change="filter">
                            <option value="count_request">인기순</option>
                            <option value="created_at">최신순</option>
                        </select>
                    </div>

                    <form @submit.prevent="filter">
                        <div class="m-input-text type01">
                            <input type="text" placeholder="업체명" v-model.lazy="form.word">

                            <img src="/img/search.png" alt="" class="m-input-text-deco" @click="filter">
                        </div>
                    </form>
                </div>
            </div>

            <div class="m-empty type01" v-if="users.data.length === 0">
                데이터가 없습니다.
            </div>

            <workers :items="users.data" v-else />

            <div class="m-btns type01 mt-80" v-if="users.links.next">
                <button class="m-btn type01 bg-primary" @click="loadMore">더보기</button>
            </div>
        </div>
    </div>
</template>
<script>
import Workers from "../../Components/Workers";
export default {
    components: {Workers},

    data() {
        return {
            users: this.$page.props.users,
            form: this.$inertia.form({
                word: this.$page.props.word,
                orderBy: this.$page.props.orderBy,
                category_ids: this.$page.props.category_ids,
                page: 1
            }),
            loading: false,
        }
    },

    methods: {
        clearCategories(){
            this.form.category_ids = [];

            this.filter();
        },

        loadMore(){
            if(!this.loading){
                this.form.page += 1;

                this.filter();
            }
        },

        filter(){
            let isLoadMore = this.users.meta.current_page !== this.form.page;

            this.loading = true;

            if(!isLoadMore)
                this.form.page = 1;

            this.form.get("/users", {
                preserveScroll: true,
                preserveState: true,
                replace: true,
                onSuccess: (response) => {
                    this.loading = false;

                    if(isLoadMore) {
                        return this.users = {
                            ...response.props.users,
                            data: [...this.users.data, ...response.props.users.data]
                        }
                    }

                    return this.users = response.props.users;
                }
            });
        }
    },

    mounted() {

    }
}
</script>
