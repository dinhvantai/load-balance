<template>
    <div role="tablist">
        <b-card no-body class="mb-1">
            <b-card-header header-tag="header" class="p-1" role="tab">
                <b-btn block href="#" 
                    v-b-toggle.admin-change-password 
                    variant="info" style="margin-top: 0px"
                >
                    {{ $t('textChangePassword') }}
                </b-btn>
            </b-card-header>
            <b-collapse visible id="admin-change-password" accordion="my-accordion" role="tabpanel">
                <b-card-body>
                    <b-form validated>
                        <b-row>
                            <b-col sm="12">
                                <div class="input-group">
                                    <b-form-input
                                        required type="password"
                                        :placeholder="$t('textOldPassword')"
                                        v-model="formData.old_password"
                                    />
                                    <span class="input-group-addon">{{ $t('textOldPassword') }}</span>
                                </div>
                                <div class="text-right text-danger mb-3">
                                    {{ formErrors.old_password }}
                                </div>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col sm="12">
                                <div class="input-group">
                                    <b-form-input
                                        required type="password"
                                        :placeholder="$t('textNewPassword')"
                                        v-model="formData.new_password"
                                    />
                                    <span class="input-group-addon">{{ $t('textNewPassword') }}</span>
                                </div>
                                <div class="text-right text-danger mb-3">
                                    {{ formErrors.new_password }}
                                </div>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col sm="12">
                                <div class="input-group">
                                    <b-form-input
                                        required type="password"
                                        :placeholder="$t('textConfirmPassword')"
                                        v-model="formData.confirm_password"
                                    />
                                    <span class="input-group-addon">{{ $t('textConfirmPassword') }}</span>
                                </div>
                                <div class="text-right text-danger mb-3">
                                    {{ errorConfirmPassword }}
                                </div>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
                <b-card-footer footer-tag="header" class="p-1 text-right" role="tab"> 
                    <b-button type="submit" size="xs" variant="primary" @click="submitChangePassword">
                        <i class="fa fa-dot-circle-o"></i>
                        {{ $t('textSave') }}
                    </b-button>
                </b-card-footer>
            </b-collapse>
        </b-card>
    </div>
</template>

<script>
import Helper from 'admin/library/Helper'
import { callApiChangePassword } from 'admin/modules/auth/api'

export default {
    name: 'Dashboard',

    beforeCreate() {
        Helper.changeTitleAdminPage(this.$i18n.t('textDashboard'))
    },

    data() {
        return {
            formData: this.resetFormData(),

            formErrors: {
                old_password: '',
                new_password: '',
            }
        }
    },

    computed: {
        errorConfirmPassword() {
            return (this.formData.confirm_password 
                    && this.formData.new_password !== this.formData.confirm_password
                ) ? this.$i18n.t('textConfirmPasswordNotCorrect') : ''
        }
    },

    methods: {
        resetFormData() {
            return {
                old_password: '',
                new_password: '',
                confirm_password: '',
            }
        },

        async submitChangePassword() {
            let params = this.formData

            if (!params.old_password || !params.new_password) {
                return this.$toaster.error(this.$i18n.t('textNotFillEnough'))
            }

            if (params.new_password !== params.confirm_password) {
                return this.$toaster.error(this.$i18n.t('textConfirmPasswordNotCorrect'))
            }

            this.$store.dispatch('setAdminLoading', { ...this.loading, show: true })
            let response = await callApiChangePassword(params)
            this.$store.dispatch('setAdminLoading', { ...this.loading, show: false })

            if (response.status == 200) {
                this.formData = this.resetFormData()

                return this.$toaster.success(response.data.message)
            } else {
                let errors = response.response.data.errors || {}
                
                this.formErrors.old_password = errors.old_password || response.response.data.error
                this.formErrors.new_password = errors.new_password

                return this.$toaster.error(Helper.getFirstError(response, this.$i18n.t('textDefaultErrorRequest')));
            }
        }
    }
}
</script>
