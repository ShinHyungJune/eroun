<template>
    <div class="subContent area-workerList">
        <div class="wrap">
            <div class="section-title type01">
                <h3 class="title">행사/이벤트 목록</h3>
                <p class="body">다양한 소식을 접해보세요!</p>
            </div>

            <div class="m-input-top type01">
                <div class="count">
                    총 <span class="primary">{{ events.meta.total }}</span>건
                </div>

                <div class="inputs">
                    <div class="m-input-select type01">
                        <select name="" id="" v-model.lazy="form.orderBy" @change="filter">
                            <option value="count_view">인기순</option>
                            <option value="created_at">최신순</option>
                        </select>
                    </div>

                    <form @submit.prevent="filter">
                        <div class="m-input-text type01">
                            <input type="text" placeholder="전문가명" v-model.lazy="form.word">

                            <img src="/img/search.png" alt="" class="m-input-text-deco" @click="filter">
                        </div>
                    </form>
                </div>
            </div>

            <div class="m-empty type01" v-if="events.data.length === 0">
                데이터가 없습니다.
            </div>

            <events :items="events.data" v-else />

            <div class="m-btns type01 mt-80" v-if="events.links.next">
                <button class="m-btn type01 bg-primary" @click="loadMore">더보기</button>
            </div>
        </div>
    </div>
</template>
<script>
import Events from "../../Components/Events";
export default {
    components: {Events},

    data() {
        return {
            events: this.$page.props.events,
            form: this.$inertia.form({
                word: this.$page.props.word,
                orderBy: this.$page.props.orderBy,
                worker: this.$page.props.worker,
                page: 1
            }),
            loading: false,
        }
    },

    methods: {
        loadMore(){
            if(!this.loading){
                this.form.page += 1;

                this.filter();
            }
        },

        filter(){
            let isLoadMore = this.events.meta.current_page !== this.form.page;

            this.loading = true;

            if(!isLoadMore)
                this.form.page = 1;

            this.form.get("/events", {
                preserveScroll: true,
                preserveState: true,
                replace: true,
                onSuccess: (response) => {
                    this.loading = false;

                    if(isLoadMore) {
                        return this.events = {
                            ...response.props.events,
                            data: [...this.events.data, ...response.props.events.data]
                        }
                    }

                    return this.events = response.props.events;
                }
            });
        }
    },

    mounted() {
        console.log(123);
    }
}
</script>
