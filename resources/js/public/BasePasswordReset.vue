<template>
  <layout-master>
    <v-container>
      <v-row justify="center" align="center">
        <v-col cols="12" sm="8" md="6">
          <v-card>
            <v-card-title>
              <h2 class="text-center">Reset Password</h2>
            </v-card-title>

            <v-form ref="form" v-model="states.is_form_valid" @submit.prevent="submitForm">

              <v-card-text>
                <v-text-field
                    type="email"
                    label="Email"
                    :error-messages="errors.email"
                    :rules="rules.email"
                    @change="errors={}"
                    v-model="inputData.email"
                />

                <!--                <v-text-field-->
                <!--                    type="password"-->
                <!--                    label="Password"-->
                <!--                    @change="errors={}"-->
                <!--                    :error-messages="errors.password"-->
                <!--                    :rules="rules.password"-->
                <!--                    v-model="inputData.password"-->
                <!--                />-->

                <text-field-password
                    label="Password"
                    :rules="rules.password"
                    v-model="inputData.password"
                    @change="errors={}"
                />

                <text-field-password
                    label="Password Again"
                    :rules="rules.password_confirmation"
                    v-model="inputData.password_confirmation"
                    @change="errors={}"
                />

                <!--  <v-text-field-->
                <!--      type="password"-->
                <!--      label="Password Again"-->
                <!--      @change="errors={}"-->
                <!--      :rules="rules.password_confirmation"-->
                <!--      v-model="inputData.password_confirmation"-->
                <!--  />-->

                <ul class="password-rules-list mt-3">
                  <li v-for="(desc, index) in passwordRulesDesc" :key="index">{{ desc }}</li>
                </ul>
              </v-card-text>

            </v-form>

            <v-card-actions>
              <v-btn color="primary" :disabled="!states.is_form_valid" @click="submitForm">Reset</v-btn>
            </v-card-actions>

          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </layout-master>
</template>

<script>
import LayoutMaster from "./layout/LayoutMaster";
import {swalMessage} from "../utils/swal/SwalHelper";
import {emailValidator} from "../utils/ValidationHelper";
import TextFieldPassword from "../partials/TextFieldPassword";
import {passwordRules, passwordRulesDesc} from "../utils/ValidationHelper";

export default {
  name: "BasePasswordReset",
  components: {TextFieldPassword, LayoutMaster},
  data() {
    return {
      states: {
        is_form_valid: false
      },
      passwordRulesDesc,
      rules: {
        email: [
          v => !!v || 'Required',
          emailValidator,
        ],
        password: passwordRules,
        password_confirmation: [
          v => !!v || "Required",
          v => this.inputData.password ? ((v && v === this.inputData.password) || "Passwords do not match!") : true,
        ],
      },
      errors: {},
      inputData: {
        email: "",
        password: "",
        password_confirmation: "",
      },
    }
  },
  props: {
    resetToken: {
      type: String,
      required: true,
    }
  },
  computed: {},
  methods: {
    submitForm() {
      if (!this.$refs.form.validate()) {
        swalMessage("error", "Please complete the form");
        return
      }
      const uri = '/reset-password';

      axios.post(uri, {...this.inputData, token: this.resetToken})
          .then((response) => swalMessage("success", response.data.data))
          .then(() => window.location = '/login')
          .catch((response) => {
            this.errors = response.response.data.errors;

            // axiosErrorCallback
          })

    }
  },
  mounted() {

  },
}
</script>

<style scoped lang="scss">
.password-rules-list {
  li {
    list-style: none;
  }
}
</style>
