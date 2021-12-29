<template>
    <div class="subContent area-workerList">
        <div class="wrap">
            <div class="section-title type01">
                <h3 class="title">섭외요청내역</h3>
                <p class="body">요청했던 내역들을 확인해보세요!</p>
            </div>

            <div class="m-input-toggle type01" style="margin-left:auto;">
                <input type="checkbox" id="123" v-if="form.mine == 1" checked="checked">
                <input type="checkbox" id="" v-else>
                <label for="" @click="toggleMine">내 섭외요청내역만 보기</label>
            </div>

            <div class="mt-20"></div>

            <div class="m-empty type01" v-if="applications.data.length === 0">
                데이터가 없습니다.
            </div>

            <applications :items="applications.data" v-else />

            <div class="m-btns type01 mt-80" v-if="applications.links.next">
                <button class="m-btn type01 bg-primary" @click="loadMore">더보기</button>
            </div>
        </div>
    </div>
</template>
<script>
import Requests from "../../Components/Requests";
export default {
    components: {Requests},

    data() {
        return {
            applications: this.$page.props.applications,
            form: this.$inertia.form({
                page: 1,
                mine: this.$page.props.mine
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
            let isLoadMore = this.applications.meta.current_page !== this.form.page;

            this.loading = true;

            if(!isLoadMore)
                this.form.page = 1;

            this.form.get("/applications", {
                preserveScroll: true,
                replace: true,
                onSuccess: (response) => {
                    this.loading = false;

                    if(isLoadMore) {
                        return this.applications = {
                            ...response.props.applications,
                            data: [...this.applications.data, ...response.props.applications.data]
                        }
                    }

                    return this.applications = response.props.applications;
                }
            });
        },

        toggleMine(){
            this.form.mine = this.form.mine == 1 ? 0 : 1;

            this.filter();
        },
    },

    mounted() {

    }
}
</script>
