<template>
    <div class="subContent area-requestCreate">
        <div class="wrap">
            <div class="section-title type01">
                <h3 class="title">섭외 문의하기</h3>
                <p class="body">작성해주신 내용을 토대로 전문가에게 섭외요청서가 전달됩니다!</p>
            </div>

            <form class="form type01" @submit.prevent="store">
                <div class="m-input-wrap type01" v-if="!user || !user.contact">
                    <div class="m-input-title">어디로 연락드리면 될가요?</div>

                    <div class="m-input-withBtn type01">
                        <div class="m-input-text type01">
                            <input type="text" placeholder="전화번호(- 없이)" v-model="form.contact" @keyup="form.contact = form.contact.replace('-', '')" disabled v-if="verified">
                            <input type="text" placeholder="전화번호(- 없이)" v-model="form.contact" @keyup="form.contact = form.contact.replace('-', '')" v-else>
                            <p class="m-input-error" v-if="form.errors.contact">{{ form.errors.contact }}</p>
                        </div>

                        <button type="button" class="m-input-btn" @click="sendVerifyNumber" v-if="!sending && !verified">
                            인증번호 발송
                        </button>
                    </div>

                    <p class="m-input-error" v-if="form.errors.contact">{{form.errors.contact}}</p>
                </div>

                <div class="m-input-wrap type01" v-if="sending && !verified">
                    <div class="m-input-title">인증번호를 입력해주세요.</div>

                    <div class="m-input-withBtn type01">
                        <div class="m-input-text type01">
                            <input type="text" placeholder="인증번호" v-model="number">
                        </div>

                        <button type="button" class="m-input-btn" @click="verifyNumber">인증하기</button>
                    </div>
                </div>

                <div class="m-input-wrap type01">
                    <div class="m-input-title">어떤 행사인가요?</div>

                    <div class="m-input-checkboxes type01">
                        <div class="m-input-checkbox type01 text">
                            <input type="text" placeholder="직접입력" v-model="form.category">
                        </div>
                        <div class="m-input-checkbox type01" v-for="requestCategory in requestCategories.data" :key="requestCategory.id">
                            <input type="radio" :id="requestCategory.id" :value="requestCategory.title" v-model="form.category">
                            <label :for="requestCategory.id">{{ requestCategory.title }}</label>
                        </div>
                    </div>

                    <p class="m-input-error" v-if="form.errors.category">{{form.errors.category}}</p>
                </div>

                <div class="m-input-wrap type01">
                    <div class="m-input-title">언제 필요하신가요?</div>

                    <div class="m-input-text type01">
                        <input type="datetime-local" placeholder="연도-월-일" v-model="form.required_at">
                    </div>
                    <p class="m-input-error" v-if="form.errors.required_at">{{form.errors.required_at}}</p>

                </div>

                <!-- 주소 연동필요 -->
                <div class="m-input-wrap type01">
                    <div class="m-input-title">어디에서 진행되나요?</div>

                    <div class="m-input-text type01">
                        <input type="text" placeholder="주소" v-model="form.address" id="address">

                        <input type="text" placeholder="상세주소" v-model="form.address_detail" id="address_detail" style="margin-top:10px;">
                    </div>

                    <p class="m-input-error" v-if="form.errors.address">{{form.errors.address}}</p>

                </div>

                <div class="m-input-wrap type01">
                    <div class="m-input-title">전문가는 몇 시간동안 필요하신가요?</div>

                    <div class="m-input-number type01">
                        <input type="text" placeholder="" v-model="form.time"> <span class="text">시간</span>
                    </div>
                    <p class="m-input-error" v-if="form.errors.time">{{form.errors.time}}</p>

                </div>

                <div class="m-input-wrap type01">
                    <div class="m-input-title">희망금액이 얼마인가요?</div>

                    <div class="m-input-number type01">
                        <input type="text" placeholder="" v-model="form.price"> <span class="text">원</span>
                    </div>
                    <p class="m-input-error" v-if="form.errors.price">{{form.errors.price}}</p>

                </div>

                <div class="m-input-wrap type01">
                    <div class="m-input-title">어떤 진행스타일을 선호하시나요?</div>

                    <div class="m-input-checkboxes type01">
                        <div class="m-input-checkbox type01 text">
                            <input type="text" placeholder="직접입력" v-model="form.style">
                        </div>
                        <div class="m-input-checkbox type01" v-for="requestStyle in requestStyles.data" :key="requestStyle.id">
                            <input type="radio" :id="'style' + requestStyle.id" :value="requestStyle.title" v-model="form.style">
                            <label :for="'style' + requestStyle.id">{{ requestStyle.title }}</label>
                        </div>
                    </div>

                    <p class="m-input-error" v-if="form.errors.style">{{form.errors.style}}</p>

                </div>

                <div class="m-input-wrap type01" style="margin-bottom:10px; padding-bottom:0; border-bottom:none;">
                    <div class="m-input-title">더 전달해주실 내용이 있나요?</div>

                    <div class="m-input-textarea type01">
                        <textarea name="" id="" placeholder="예) 주의사항, 요청사항" v-model="form.comment"></textarea>
                    </div>

                    <p class="m-input-error" v-if="form.errors.comment">{{form.errors.comment}}</p>

                </div>

                <div class="m-btns type01">
                    <button class="m-btn type01 bg-down width-100">견적요청하기</button>
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
                category: "",
                time: "",
                address: "",
                address_detail: "",
                contact: "",
                price: "",
                style: "",
                comment: "",
                required_at: ""
            }),
            requestCategories: this.$page.props.requestCategories,
            requestStyles: this.$page.props.requestStyles,
            sending : false,
            verified: false,
            number: "",
            user: this.$page.props.user.data
        }
    },

    methods: {
        store(){
            this.form.post("/requests", {
                onSuccess: (response) => {
                    if(response.props.flash.error)
                        alert(response.props.flash.error);

                    if(response.props.flash.success)
                        alert(response.props.flash.success);
                }
            });
        },

        sendVerifyNumber(){
            this.sending = true;

            axios.post("/verifyNumbers", {
                "contact" : this.form.contact
            }).then(response => {
                console.log(response);
            });
        },

        verifyNumber(){
            axios.patch("/verifyNumbers", {
                "contact" : this.form.contact,
                "number" : this.number
            }).then(response => {
                alert(response.data.message);

                this.verified = true;
            }).catch(error => {
                alert(error.response.data.message);
            })
        }
    },

    mounted() {
        let self = this;

        document.getElementById("address").addEventListener("click", function(){ //주소입력칸을 클릭하면
            //카카오 지도 발생
            new daum.Postcode({
                oncomplete: function(data) { //선택시 입력값 세팅
                    self.form.address = data.address;
                    document.getElementById("address_detail").focus(); // 주소 넣기
                }
            }).open();
        });
    }
}
</script>
