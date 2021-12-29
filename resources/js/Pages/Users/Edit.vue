<template>
    <div class="subContent area-register area-login area-update">
        <div class="wrap">
            <div class="section-title type01">
                <h3 class="title">회원정보입력</h3>
                <p class="body">원활한 상담을 위해 기본정보를 입력해주세요!</p>
            </div>

            <form class="form type02" @submit.prevent="update">

                <div class="m-input-wrap type01">
                    <div class="m-input-img type01">
                        <input type="file" id="img" accept="image/*" @change="changeFile">

                        <label for="img" class="m-ratioBox-wrap">
                            <div class="m-ratioBox">
                                <img :src="preview" alt="">
                            </div>
                        </label>
                    </div>

                    <p class="m-input-error" v-if="form.errors.img">{{ form.errors.img }}</p>
                </div>

                <div class="m-input-wrap type01" v-if="form.worker == 1">
                    <div class="m-input-select type01">
                        <select name="" id="" v-model="form.category_id">
                            <option value="" disbled selected>카테고리</option>
                            <option :value="category.id" v-for="category in categories.data" :key="category.id">
                                {{ category.title }}
                            </option>
                        </select>
                    </div>
                    <p class="m-input-error" v-if="form.errors.category_id">{{ form.errors.category_id }}</p>
                </div>
                <div class="m-input-wrap type01" v-if="form.worker == 1">
                    <div class="m-input-text type01">
                        <input type="text" placeholder="경력" v-model="form.career">
                    </div>
                    <p class="m-input-error" v-if="form.errors.career">{{ form.errors.career }}</p>
                </div>
                <div class="m-input-wrap type01">
                    <div class="m-input-select type01">
                        <select name="" id="" v-model="form.worker">
                            <option value="0">일반사용자</option>
                            <option value="1">전문가</option>
                        </select>
                    </div>
                    <p class="m-input-comment">고객들로부터 의뢰를 받고자 하는 전문가님은 일반사용자가 아닌 전문가를 선택해주세요!</p>
                    <p class="m-input-error" v-if="form.errors.worker">{{ form.errors.worker }}</p>
                </div>
                <div class="m-input-wrap type01">
                    <div class="m-input-withBtn type01">
                        <div class="m-input-text type01">
                            <input type="text" placeholder="전화번호(- 없이)" v-model="form.contact"
                                   @keyup="form.contact = form.contact.replace('-', '')" disabled v-if="verified">
                            <input type="text" placeholder="전화번호(- 없이)" v-model="form.contact"
                                   @keyup="form.contact = form.contact.replace('-', '')" v-else>
                            <p class="m-input-error" v-if="form.errors.contact">{{ form.errors.contact }}</p>
                        </div>

                        <button type="button" class="m-input-btn" @click="sendVerifyNumber"
                                v-if="!sending && !verified">
                            인증번호 발송
                        </button>
                    </div>
                </div>

                <div class="m-input-wrap type01" v-if="sending && !verified">
                    <div class="m-input-withBtn type01">
                        <div class="m-input-text type01">
                            <input type="text" placeholder="인증번호" v-model="number">
                        </div>

                        <button type="button" class="m-input-btn" @click="verifyNumber">인증하기</button>
                    </div>
                </div>

                <div class="m-input-wrap type01">
                    <div class="m-input-text type01">
                        <input type="text" placeholder="이름" v-model="form.name" autocomplete="off">
                        <p class="m-input-error" v-if="form.errors.name">{{ form.errors.name }}</p>
                    </div>
                </div>
                <div class="m-input-wrap type01">
                    <div class="m-input-text type01">
                        <input type="text" placeholder="주소" v-model="form.address">
                        <p class="m-input-error" v-if="form.errors.address">{{ form.errors.address }}</p>
                    </div>
                </div>
                <div class="m-input-wrap type01">
                    <div class="m-input-text type01">
                        <input type="text" placeholder="이메일" v-model="form.email">
                        <p class="m-input-error" v-if="form.errors.email">{{ form.errors.email }}</p>
                    </div>
                </div>

                <!-- <textarea v-model="form.description" id="editor"></textarea> -->
                <div class="m-input-wrap type01">
                    <textarea id="editor" v-model="form.description"></textarea>
                </div>

                <button class="m-btn type01 bg-primary width-100">저장하기</button>
            </form>
        </div>
    </div>
</template>
<script>
import CustomCkeditor from "../../Utils/CustomCkeditor";

export default {
    data() {
        return {
            form: this.$inertia.form({
                img: "",
                worker: this.$page.props.user.data.worker,
                contact: this.$page.props.user.data.contact,
                name: this.$page.props.user.data.name,
                address: this.$page.props.user.data.address,
                email: this.$page.props.user.data.email,
                category_id: this.$page.props.user.data.categories.length !== 0 ? this.$page.props.user.data.categories[0].id : "",
                career: this.$page.props.user.data.career,
                description: this.$page.props.user.data.description,
            }),
            categories: this.$page.props.categories,
            sending: false,
            verified: false,
            number: "",
        }
    },

    methods: {
        update() {
            this.form.description = window.editor.getData();
            console.log(window.editor.getData());
            this.form.post("/users/update", {
                forceFormData: true,
                preserveScroll: true,
                onSuccess: (response) => {
                    if (response.props.flash.error)
                        alert(response.props.flash.error);

                    if (response.props.flash.success)
                        alert(response.props.flash.success);
                }
            });
        },

        changeFile(event) {
            this.form.img = event.target.files[0];
        },

        sendVerifyNumber() {
            this.sending = true;

            axios.post("/verifyNumbers", {
                "contact": this.form.contact
            }).then(response => {
                console.log(response);
            });
        },

        verifyNumber() {
            axios.patch("/verifyNumbers", {
                "contact": this.form.contact,
                "number": this.number
            }).then(response => {
                alert(response.data.message);

                this.verified = true;
            }).catch(error => {
                alert(error.response.data.message);
            })
        }
    },

    computed: {
        preview() {
            if (this.form.img)
                return URL.createObjectURL(this.form.img);

            if (this.$page.props.user.data.img.url)
                return this.$page.props.user.data.img.url;
        }
    },

    mounted() {
        new CustomCkeditor("#editor").create();
    }
}
</script>
