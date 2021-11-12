<template>
    <header class="header">
        <Link href="/">
            <img src="/img/logo-white.png" alt="" class="logo">
        </Link>

        <div class="black"></div>

        <div class="right">
            <nav class="navs">
                <div class="nav">
                    <a href="#" class="text">WHO WE ARE</a>
                    <div class="navs">
                        <div class="nav">
                            <Link href="/whoWeAre/aboutUs" class="text">About Us</Link>
                        </div>
                        <div class="nav">
                            <Link href="/whoWeAre/ourMission" class="text">Our Mission & Vision</Link>
                        </div>
                        <div class="nav">
                            <Link href="/whoWeAre/ourStaff" class="text">Our Staff</Link>
                        </div>
                        <div class="nav">
                            <Link href="/whoWeAre/contactUs" class="text">Contact Us</Link>
                        </div>
                    </div>
                </div>

                <div class="nav">
                    <a href="#" class="text">ACADEMICS</a>
                    <div class="navs">
                        <div class="nav">
                            <Link href="/academics/middleSchool" class="text">Middle School</Link>
                        </div>
                        <div class="nav">
                            <Link href="/academics/highSchool" class="text">High School</Link>
                        </div>
<!--                        <div class="nav">
                            <Link href="/academics/aboutAp" class="text">About AP</Link>
                        </div>-->
                        <div class="nav">
                            <Link href="/academics/apCourses" class="text">AP Courses</Link>
                        </div>
                        <div class="nav">
                            <Link href="/academics/onlineEsl" class="text">Online ESL</Link>
                        </div>
                        <div class="nav">
                            <Link href="/academics/whartonSchool" class="text">Graduation Requirements</Link>
                        </div>
                    </div>
                </div>

                <div class="nav">
                    <a href="#" class="text">ADMISSIONS</a>
                    <div class="navs">
                        <div class="nav">
                            <Link href="/admission/admissions" class="text">Admissions</Link>
                        </div>
                        <div class="nav">
                            <Link href="/admission/applyNow" class="text">Apply Now</Link>
                        </div>
                        <div class="nav">
                            <Link href="/admission/whsGlobal" class="text">Wharton Global <br/>Pathway Program</Link>
                        </div>
                        <div class="nav">
                            <Link href="/admission/qna" class="text">Q&A</Link>
                        </div>
                    </div>
                </div>

                <div class="nav">
                    <a href="#" class="text">TUITION</a>
                    <div class="navs">
                        <div class="nav">
                            <Link href="/tuition/tuition" class="text">Tuition & Fees</Link>
                        </div>
                        <div class="nav">
                            <Link href="/tuition/financialAid" class="text">Financial Aid</Link>
                        </div>
                    </div>
                </div>

                <div class="nav">
                    <a href="#" class="text">COMMUNITY</a>
                    <div class="navs">
                        <div class="nav">
                            <Link href="/community/blogs" class="text">Blogs</Link>
                        </div>
                        <div class="nav">
                            <Link href="/community/whartonSchool" class="text">Wharton Classroom</Link>
                        </div>
                    </div>
                </div>
                <div class="nav">
                    <a href="#" class="text">ENROLL NOW</a>
                    <div class="navs">
                        <div class="nav">
                            <Link href="/enrollNow/enrollNow" class="text">Enroll Now</Link>
                        </div>
                        <div class="nav">
                            <Link href="/enrollNow/documentsDownloads" class="text">Documents Download</Link>
                        </div>
                        <div class="nav">
                            <Link href="/enrollNow/requestTranscript" class="text">Request Transcript</Link>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="utils">
                <button class="util">
                    <span class="icon-wrap">
                        <img src="/img/search-white.png" alt="" class="icon">
                    </span>

                    SEARCH

                    <form @submit.prevent="search">
                        <div class="m-input-text type01">
                            <input type="text" v-model="form.word">
                            <img src="/img/search.png" alt="" class="m-input-text-deco" @click="search">
                        </div>
                    </form>

                </button>

                <Link href="/login" class="util" v-if="!$page.props.user">
                    <span class="icon-wrap">
                        <img src="/img/user-white.png" alt="" class="icon">
                    </span>

                    LOGIN
                </Link>

                <Link href="/logout" class="util" v-else>
                    <span class="icon-wrap">
                        <img src="/img/user-white.png" alt="" class="icon">
                    </span>

                    LOGOUT
                </Link>
            </div>
        </div>

        <button class="btn-menu"></button>
    </header>
</template>
<script>
import {Link} from '@inertiajs/inertia-vue';
export default {
    components: {Link},
    data(){
        return {
            form: this.$inertia.form({
                word: ""
            })
        }
    },
    methods: {
        search(){
            this.form.get("/academics/highSchool");

            $(".header .util").removeClass("active");
        }
    }
}
</script>
