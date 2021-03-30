<template>
  <profile-update-layout title="Password">

    <template v-slot:body>
      <v-form v-model="states.is_form_valid" @submit.prevent="save">

        <text-field-password
            autofocus
            class="mx-12"
            @input="edit"
            :rules="rules.old_password"
            label="Old Password"
            v-model="inputData.old_password"
        />

        <text-field-password
            class="mx-12"
            @input="edit"
            :rules="rules.password"
            label="Password"
            v-model="inputData.password"
        />

        <text-field-password
            class="mx-12"
            @change="save"
            @input="edit"
            :rules="rules.password_confirmation"
            label="Password Again"
            v-model="inputData.password_confirmation"
        />

        <ul class="password-rules-list mx-5 mt-3">
          <li v-for="(desc, index) in passwordRulesDesc" :key="index" >{{ desc }}</li>
        </ul>

      </v-form>

    </template>

    <template v-slot:actions>

      <div class="ml-auto">
        <v-btn color="primary" :disabled="!states.hasEdited || !states.is_form_valid" text @click="save">
          Save
        </v-btn>
      </div>
    </template>

  </profile-update-layout>
</template>

<script>
import ProfileUpdateLayout from "../ProfileUpdateLayout";
import ProfileUpdateMixin from "../ProfileUpdateMixin";
import TextFieldPassword from "../../../../partials/TextFieldPassword";
import {passwordRules, passwordRulesDesc} from "../../../../utils/ValidationHelper";
import BaseAvatar from "../../../../partials/BaseAvatar";

export default {
  name: "ProfileUpdatePassword",
  mixins: [ProfileUpdateMixin],
  components: {BaseAvatar, TextFieldPassword, ProfileUpdateLayout},
  data() {
    return {
      passwordRulesDesc,
      states: {
        is_form_valid: true,
        hasEdited: false,
      },
      inputData: {
        old_password: null,
        password: null,
        password_confirmation: null,
      },
      rules: {
        old_password: [
          v => !!v || "Required",
        ],
        password: passwordRules,
        password_confirmation: [
          v => !!v || "Required",
          v => this.inputData.password ? ((v && v === this.inputData.password) || "Passwords do not match!") : true,
        ],
      },
    }
  },

}
</script>

<style scoped lang="scss">
  .password-rules-list{
    li {
      list-style: none;
    }
  }
</style>
