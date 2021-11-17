<template>
    <div class="subContent area-requestCreate">
        <div class="wrap">
            <div class="section-title type01">
                <h3 class="title">리뷰 작성하기</h3>
                <p class="body">후기를 남겨주세요!</p>
            </div>

            <form class="form type01" @submit.prevent="store">
                <div class="m-input-wrap type01">
                    <div class="m-input-title">전문가와의 경험이 어떠셨나요?</div>

                    <div class="m-input-textarea type01">
                        <textarea name="" id="" placeholder="후기" v-model="form.description"></textarea>
                    </div>

                    <p class="m-input-error" v-if="form.errors.description">{{form.errors.description}}</p>
                </div>

                <div class="m-input-wrap type01">
                    <div class="m-input-title">몇점을 드리고 싶나요?</div>

                    <div class="m-input-select type01">
                        <select name="" id="" v-model="form.score">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>

                    <p class="m-input-error" v-if="form.errors.score">{{form.errors.score}}</p>
                </div>

                <div class="m-btns type01">
                    <button class="m-btn type01 bg-down width-100">작성하기</button>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            form: this.$inertia.form({
                worker_id: this.$page.props.worker_id,
                description: "",
                score: 1
            }),
        }
    },

    methods: {
        store(){
            this.form.post("/reviews", {
                onSuccess: (response) => {
                    if(response.props.flash.error)
                        alert(response.props.flash.error);

                    if(response.props.flash.success)
                        alert(response.props.flash.success);
                }
            });
        },
    },
}
</script>
