<template>
    <div class="area-main">
        <section class="section section01">
            <div class="swiper">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="/img/visual01.jpg" alt="" class="visual">

                            <div class="box-text">
                                <h3 class="title">
                                    WHARTON
                                    <br/>SCHOOL
                                </h3>

                                <p class="body">
                                    Begin the journey of your lifetime.
                                    <br/>The world is waiting.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <img src="/img/icon-scroll.png" alt="" class="icon">
        </section>

        <section class="section section02">
            <div class="wrap">
                <div class="section-title" data-aos="fade-up" data-aos-duration="1500">
                    <h4 class="subtitle primary">A different way to live and learn.</h4>
                    <h3 class="title">
                        The Wharton experience challenges you to reach your potential.
                        <br/>It’s about connecting with others and forging lifelong friendships.
                        <br/>There’s always something new to explore.
                    </h3>
                </div>
            </div>

            <div class="boxes" data-aos="fade-up" data-aos-duration="1500">
                <div class="box">
                    <div class="m-ratioBox-wrap">
                        <div class="deco-wrap">
                            <div class="deco"></div>
                        </div>

                        <div class="m-ratioBox">
                            <img src="/img/main-visual01.jpg" alt="" class="visual">
                        </div>
                    </div>

                    <div class="box-text">
                        <div class="content">
                            <h3 class="title">COMMUNITY</h3>
                            <p class="body">
                                Feel free to share your opinions
                                <br/>and ask questions in the community
                            </p>
                        </div>
                    </div>
                </div>

                <div class="box">
                    <div class="m-ratioBox-wrap">
                        <div class="deco-wrap">
                            <div class="deco"></div>
                        </div>

                        <div class="m-ratioBox">
                            <img src="/img/main-visual02.jpg" alt="" class="visual">
                        </div>
                    </div>

                    <div class="box-text">
                        <div class="content">
                            <h3 class="title">AP COURSES</h3>
                            <p class="body">
                                Explore and study various courses
                                <br/>unique to Wharton!
                            </p>
                        </div>
                    </div>
                </div>

                <div class="box">
                    <div class="m-ratioBox-wrap">
                        <div class="deco-wrap">
                            <div class="deco"></div>
                        </div>

                        <div class="m-ratioBox">
                            <img src="/img/main-visual03.jpg" alt="" class="visual">
                        </div>
                    </div>

                    <div class="box-text">
                        <div class="content">
                            <h3 class="title">DUAL ENROLLMENT</h3>
                            <p class="body">
                                Take college-provided courses
                                <br/>to earn college credit in advance
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section section03">
            <div class="wrap">
                <div class="section-title" data-aos="fade-up" data-aos-duration="1500">
                    <h3 class="title">CONTACT US</h3>
                </div>

                <div class="box-content" data-aos="fade-up" data-aos-duration="1500">
                    <div class="m-ratioBox-wrap">
                        <div class="m-ratioBox">
                            <img src="/img/img-contact01.jpg" alt="">
                        </div>
                    </div>

                    <div class="content">
                        <p class="comment primary">
                            Thank you for your interest in Wharton School! Fill out this form
                            to receive information about admissions and upcoming events.
                        </p>

                        <form @submit.prevent="submitContact">
                            <div class="m-input-wrap type01">
                                <div class="m-input-text type01">
                                    <input type="text" placeholder="First name *" v-model="contactForm.first_name">
                                </div>

                                <p class="m-input-error" v-if="contactForm.errors.first_name">{{contactForm.errors.first_name}}</p>
                            </div>

                            <div class="m-input-wrap type01">
                                <div class="m-input-text type01">
                                    <input type="text" placeholder="Last name *" v-model="contactForm.last_name">
                                </div>

                                <p class="m-input-error" v-if="contactForm.errors.last_name">{{contactForm.errors.last_name}}</p>
                            </div>

                            <div class="m-input-wrap type01">
                                <div class="m-input-text type01">
                                    <input type="text" placeholder="Phone *" v-model="contactForm.phone">
                                </div>

                                <p class="m-input-error" v-if="contactForm.errors.phone">{{contactForm.errors.phone}}</p>
                            </div>

                            <div class="m-input-wrap type01">
                                <div class="m-input-text type01">
                                    <input type="text" placeholder="Email *" v-model="contactForm.email">
                                </div>

                                <p class="m-input-error" v-if="contactForm.errors.email">{{contactForm.errors.email}}</p>
                            </div>

                            <div class="m-input-wrap type01">
                                <div class="m-input-select type01">
                                    <select name="" id="" v-model="contactForm.interest">
                                        <option value="" selected disabled>Interest *</option>
                                        <option value="Standard high school full-time enrollment">Standard high school full-time enrollment</option>
                                        <option value="AP courses">AP courses</option>
                                        <option value="Chinese Proficiency Test HSK preparation courses">Chinese Proficiency Test HSK preparation courses</option>
                                        <option value="Individual courses">Individual courses</option>
                                    </select>
                                </div>

                                <p class="m-input-error" v-if="contactForm.errors.interest">{{contactForm.errors.interest}}</p>
                            </div>

                            <div class="m-input-wrap type01">
                                <div class="m-input-textarea type01">
                                    <textarea name="" id="" placeholder="Comment" v-model="contactForm.comment"></textarea>
                                </div>

                                <p class="m-input-error" v-if="contactForm.errors.comment">{{contactForm.errors.comment}}</p>
                            </div>

                            <button class="m-btn type01 bg-primary">SUBMIT</button>
                        </form>
                    </div>
                </div>

            </div>
        </section>

        <section class="section section04">
            <img src="/img/base-program01.jpg" alt="" class="visual">
            <div class="wrap">
                <h3 class="title" data-aos="fade-up" data-aos-duration="1500">
                    Enroll In
                    <br/>Our School Program
                    <br/>Year Round
                </h3>

                <p class="comment" data-aos="fade-up" data-aos-duration="1500">
                    Our online school program is ideal for students (grades 6-12) who want to get a real high school diploma
                    <br/>on their own schedule, from anywhere in the world. This rigorous college preparatory high school program
                    <br/>gives students the opportunity to learn in an interactive format, built for the 21st century.
                </p>
                <p class="comment" data-aos="fade-up" data-aos-duration="1500">
                    With homeschooling becoming more prominent than ever before, Wharton is the perfect solution for high school
                    <br/>students looking for an innovative way of learning through the use of technology. With online classes accredited
                    <br/>by the Nevada Department of Education, students from anywhere can receive a high school diploma. What’s more?
                    <br/>We offer year-round enrollment, which makes getting a high school education even more convenient.
                </p>
            </div>
        </section>

        <section class="section section05">
            <div class="wrap">
                <div class="section-title" data-aos="fade-up" data-aos-duration="1500">
                    <h4 class="subtitle primary">WHARTON STRENGTH</h4>
                    <h3 class="title">
                        <span class="point">Why Parents & Students Choose</span>
                        Wharton School
                    </h3>
                </div>

                <div class="boxes" data-aos="fade-up" data-aos-duration="1500">
                    <div class="box-wrap">
                        <div class="box">
                            <h3 class="title">Over 100 Courses Available</h3>

                            <p class="body">
                                Gain access to over 100 engaging and
                                <br/>interactive courses -- tailored for students
                                <br/>in grades 9-12 -- including
                                <br/>Advanced Placement.
                            </p>

                            <div class="m-ratioBox-wrap">
                                <div class="m-ratioBox">
                                    <img src="/img/img-strength01.jpg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box-wrap">
                        <div class="box">
                            <h3 class="title">Affordable Tuition</h3>

                            <p class="body">
                                Our monthly pay-as-you-go plans
                                <br/>are flexible to fit your budget.
                            </p>

                            <div class="m-ratioBox-wrap">
                                <div class="m-ratioBox">
                                    <img src="/img/img-strength02.jpg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box-wrap">
                        <div class="box">
                            <h3 class="title">Flexible Learning</h3>

                            <p class="body">
                                Enroll anytime of the year and
                                <br/>start learning immediately.
                                <br/>Learn at your own pace and on your
                                <br/>own schedule from anywhere in the world.
                            </p>

                            <div class="m-ratioBox-wrap">
                                <div class="m-ratioBox">
                                    <img src="/img/img-strength03.jpg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section section06">
            <div class="wrap">
                <div class="section-title" data-aos="fade-up" data-aos-duration="1500">
                    <h4 class="subtitle primary">WHARTON REVIEW</h4>
                    <h3 class="title">
                        <span class="point">What Our</span> Students and Parents <span class="point">Are Saying</span>
                    </h3>
                </div>
            </div>

            <div class="swiper" data-aos="fade-up" data-aos-duration="1500">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="m-ratioBox-wrap">
                                <div class="m-ratioBox">
                                    <img src="/img/review01.jpg" alt="">
                                </div>
                            </div>

                            <h3 class="title">Mary Evans</h3>
                            <p class="body">
                                I learned AP Chinese here since last year. As a ABC,
                                I thought it's quite helpful for me to pass AP Chinese exam.
                            </p>

                            <div class="stars">
                                <img src="/img/star-active.png" alt="" class="star">
                                <img src="/img/star-active.png" alt="" class="star">
                                <img src="/img/star-active.png" alt="" class="star">
                                <img src="/img/star-active.png" alt="" class="star">
                                <img src="/img/star-active.png" alt="" class="star">
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="m-ratioBox-wrap">
                                <div class="m-ratioBox">
                                    <img src="/img/review02.jpg" alt="">
                                </div>
                            </div>

                            <h3 class="title">Vennie</h3>
                            <p class="body">
                                Thank you so much for all your help with Amanda
                                for the API Chinese exam prep. My daugther passed her exam!
                            </p>

                            <div class="stars">
                                <img src="/img/star-active.png" alt="" class="star">
                                <img src="/img/star-active.png" alt="" class="star">
                                <img src="/img/star-active.png" alt="" class="star">
                                <img src="/img/star-active.png" alt="" class="star">
                                <img src="/img/star-active.png" alt="" class="star">
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="m-ratioBox-wrap">
                                <div class="m-ratioBox">
                                    <img src="/img/review03.jpg" alt="">
                                </div>
                            </div>

                            <h3 class="title">David Lucas</h3>
                            <p class="body">
                                I'm so lucky to take these courses! They are really helpful, and I've
                                4 in the AP test... I also learned a lot about Chinese culture.
                            </p>

                            <div class="stars">
                                <img src="/img/star-active.png" alt="" class="star">
                                <img src="/img/star-active.png" alt="" class="star">
                                <img src="/img/star-active.png" alt="" class="star">
                                <img src="/img/star-active.png" alt="" class="star">
                                <img src="/img/star-active.png" alt="" class="star">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-btns">
                    <img src="/img/arrowLeft-black.png" alt="" class="swiper-btn swiper-btn-prev">
                    <img src="/img/arrowRight-black.png" alt="" class="swiper-btn swiper-btn-next">
                </div>
            </div>
        </section>
    </div>
</template>
<script>
export default {
    data() {
        return {
            contactForm: this.$inertia.form({
                "first_name" : null,
                "last_name": null,
                "phone": null,
                "email": null,
                "interest" : "",
                "comment" : null,
                "checked" : null
            })
        }
    },

    methods: {
        submitContact(){
            this.contactForm.post("/contacts", {
                preserveScroll: true,
                onSuccess: (response) => {
                    alert(response.props.flash.success);

                    this.contactForm.reset()
                }
            })
        }
    },

    mounted(){
        AOS.init();

        let swiper = new Swiper('.section06 .swiper-container', {
            spaceBetween: 60,
            centeredSlides: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            loop: true,
            slidesPerView: 3,
            navigation: {
                nextEl: '.section06 .swiper-btn-next',
                prevEl: '.section06 .swiper-btn-prev',
            },
            breakpoints: {
                1200: {
                    slidesPerView: 2
                },
                768: {
                    slidesPerView: 1.2,
                    spaceBetween: 20
                }
            }
        });
    }
}
</script>
