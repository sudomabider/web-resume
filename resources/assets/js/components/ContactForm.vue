<template>
    <transition name="fade" mode="out-in">
        <form @submit.prevent="submit" id="contact-form" v-if="!sent">

            <div class="alert alert-danger" v-if="errors.length > 0" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" @click="closeErrors">
                    <span aria-hidden="true">&times;</span>
                </button>
                <ul class="list-unstyled">
                    <li v-for="error in errors">
                        {{ error }}
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <input v-model="name" type="text" class="form-control" placeholder="Your Name">
                </div>
                <div class="form-group col-md-6">
                    <input v-model="email" type="email" class="form-control" placeholder="Your Email">
                </div>
            </div>

            <div class="form-group">
                <textarea v-model="message" rows="5" class="form-control" placeholder="Your Message"></textarea>
            </div>

            <div class="form-group">
                <VueRecaptcha ref="recaptcha" :sitekey="siteKey"></VueRecaptcha>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-info btn-block">
                    <i class="fa fa-send-o fa-fw"></i> SEND
                </button>
            </div>
        </form>
        <div v-if="sent" class="text-xs-center">
            <div class="alert alert-success">
                <h4>Thanks for your message!</h4>
                I'll get back to you when I can if necessary.
            </div>
            <div class="text-xs-center">
                <a href="#" @click.prevent="refresh" class="text-muted">Send another one?</a>
            </div>
        </div>
    </transition>
</template>

<script>
    import VueRecaptcha from 'vue-recaptcha'
    import contactService from '../services/ContactService'

    export default {
      data() {
        return {
          name: '',
          email: '',
          message: '',
          sent: false,
          errors: []
        }
      },
      computed: {
        siteKey() {
          return window.recaptchaKey;
        }
      },
      methods: {
        closeErrors() {
          this.errors = [];
        },
        refresh() {
          this.name = '';
          this.email = '';
          this.message = '';
          this.sent = false;
          this.errors = [];
        },
        submit() {
          const data = JSON.stringify({
            name: this.name,
            email: this.email,
            message: this.message,
            recaptcharesponse: document.querySelector('[name="g-recaptcha-response"]').value
          });
          contactService.post(data).then(({data}) => {
            this.$refs.recaptcha.reset();
            this.sent = true;
          }, (error) => {
            this.$refs.recaptcha.reset();

            // server error
            if (error.status === 500) {
              this.errors = ['Whoops! Something went wrong. Please refresh and try again.'];
              return;
            }

            error.json().then(errors => {
              if (typeof errors === 'string') {
                this.errors = [errors];
              }
              else if (typeof errors === 'object') {
                this.errors = this.parseErrors(errors);
              }
              else {
                this.errors = ['Whoops! Something went wrong. Please refresh and try again.'];
              }
            });
          });
        },
        parseErrors(errors) {
          errors = Object.values(errors);
          let messages = [];
          for (const key in errors) {
            messages = messages.concat(errors[key]);
          }
          return messages;
        }
      },

      components: { VueRecaptcha }
    }
</script>