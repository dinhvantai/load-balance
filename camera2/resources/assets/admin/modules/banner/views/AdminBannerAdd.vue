<template>
    <b-modal
        :title="$t('textAddBanner')"
        v-model="openModalValue"
        @ok="submitModalAdd"
        @hidden="hideModalAdd"
        :centered="true" size="lg"
    >
        <b-row>
            <b-col sm="12">
                <b-form validated>
                    <b-row>
                        <b-col sm="10">
                            <b-form-fieldset :label="$t('textName')">
                                <b-form-input type="text" :placeholder="$t('textName')" v-model="formData.name"/>
                            </b-form-fieldset>
                        </b-col>
                        <b-col sm="2" class="text-center">
                            <b-form-fieldset :label="$t('textStatus')">
                                <c-switch
                                    type="text" variant="primary-outline-alt"
                                    on="On" off="Off"
                                    :pill="true" :checked="true"
                                    v-model="formData.status"
                                />
                            </b-form-fieldset>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col sm="6">
                            <b-form-fieldset :label="$t('textLink')">
                                <b-form-input
                                    type="text"
                                    :placeholder="$t('textLink')"
                                    v-model="formData.link"
                                />
                            </b-form-fieldset>
                        </b-col>
                        <b-col sm="6">
                            <b-form-fieldset :label="$t('textPosition')">
                                <b-form-select
                                    :plain="true" required
                                    :options="optionPosition"
                                    v-model="formDataPosition"
                                >
                                </b-form-select>
                            </b-form-fieldset>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col sm="12">
                            <b-form-fieldset :label="$t('textImage')"
                                style="boder: 1px solid #E5E5E5"
                            >
                                <vue-transmit
                                    tag="section"
                                    v-bind="uploadOptions"
                                    @success="successUploader"
                                    @error="errorUploader"
                                    upload-area-classes="bg-faded"
                                    ref="uploader"
                                >
                                    <b-row>
                                        <b-col sm="2"
                                            style="border-radius: 1px; boder: 1px solid #DCDCDC"
                                            class="text-left"
                                        >
                                            <button class="btn btn-primary"
                                            @click="triggerBrowse"
                                        >{{ $t('textUploadFile') }}</button>
                                        </b-col>
                                    </b-row>
                                    <!-- Scoped slot -->
                                    <template slot="files" slot-scope="props">
                                        <div v-for="(file, i) in props.files" :key="file.id" :class="{'mt-5': i === 0}">
                                            <div class="media">
                                                <img :src="file.dataUrl" class="img-fluid d-flex mr-3">
                                                <div class="media-body">
                                                    <div class="progress">
                                                        <div class="progress-bar bg-success"
                                                            :style="{width: file.upload.progress + '%'}"
                                                        >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </vue-transmit>
                            </b-form-fieldset>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col sm="6">
                            <b-form-fieldset :label="$t('textSeoKeyword')">
                                <b-form-input
                                    type="text"
                                    :placeholder="$t('textSeoKeyword')"
                                    v-model="formData.seo_keyword"
                                />
                            </b-form-fieldset>
                        </b-col>
                        <b-col sm="6">
                            <b-form-fieldset :label="$t('textSeoDescription')">
                                <b-form-input
                                    type="text"
                                    :placeholder="$t('textSeoDescription')"
                                    v-model="formData.seo_description"
                                />
                            </b-form-fieldset>
                        </b-col>
                    </b-row>
                </b-form>
            </b-col><!--/.col-->
        </b-row>
        <div slot="modal-footer" class="w-100 text-center">
            <b-button type="submit" size="xs" variant="primary" @click="clickAddMenu">
                <i class="fa fa-dot-circle-o"></i>
                {{ $t('textAddNew') }}
            </b-button>
            <b-button type="reset" size="xs" variant="danger" @click="hideModalAdd">
                <i class="fa fa-ban"></i>
                {{ $t('textCancel') }}
            </b-button>
       </div>
    </b-modal>
</template>

<script>
import cSwitch from 'assets/components/Switch.vue'

import { ADMIN_BANNER_POSITION_OPTION } from '../store'
import { STORAGE_AUTH } from 'admin/modules/auth/store'
import Helper from 'admin/library/Helper'

export default {
    name: 'AdminMenuAdd',

    components: { cSwitch },

    props: {
        modalAdd: {
            type: Object,
            required: true
        },
        submitModalAdd: {
            type: Function,
            required: true
        },
        hideModalAdd: {
            type: Function,
            required: true
        },
    },

    data() {
        let token = JSON.parse(localStorage.getItem(STORAGE_AUTH)).token
        let today = new Date()

        return {
            optionPosition: ADMIN_BANNER_POSITION_OPTION.map(option => (
                { value: option.value, text: this.$i18n.t(option.text) }
            )),

            showUploadFile: true,

            formData: this.resetFormData(),

            uploadOptions: {
                acceptedFileTypes: ['image/*'],
                url: '/api/v0/upload-image',
                clickable: false,
                params: {
                    folder: `menu-${today.getFullYear()}
                        -${today.getMonth() + 1}
                        -${today.getDate()}
                    `,
                },
                maxFiles: 1,                
                paramName: 'image',
                headers: {
                    Authorization: `${token.token_type} ${token.access_token}`
                }
            }
        }
    },

    methods: {
        triggerBrowse(event) {
            event.preventDefault()

            if (this.$refs.uploader.files.length >= this.uploadOptions.maxFiles) {
                return this.$toaster.error(this.$i18n.t('textNotAddFile'));
            }
            
            return this.$refs.uploader.triggerBrowseFiles()
        },

        successUploader(response) {
            let serveRespone = JSON.parse(response.xhr.response)
            
            return this.formData.image = serveRespone.path
        },

        errorUploader(error) {
            let files = this.$refs.uploader.files
            let xhr = { response: JSON.parse(error.xhr.response) }
            
            this.$toaster.error(Helper.getFirstError(xhr, this.$i18n.t('textDefaultErrorRequest')))

            return this.$refs.uploader.files.length = files.length - 1;
        },

        resetFormData() {
            return this.formData = {
                name: '',
                link: '',
                image: '',
                position: this.$store.state.storeAdminBanner.currentTab,
                status: true,
                seo_keyword: '',
                seo_description: '',
            }
        },

        clickAddMenu() {
            let params = this.formData

            if (!params.image) {
                return this.$toaster.error(this.$i18n.t('textPleaseUploadImage'))
            }

            if (!params.position) {
                return this.$toaster.error(this.$i18n.t('textNotFillEnough'))
            }

            this.resetFormData()
            this.$refs.uploader.files = []

            return this.submitModalAdd(params)
        }
    },

    computed: {
        openModalValue: {
            get() {
                return this.modalAdd.open
            },
            set(val) {
            }
        },

        formDataPosition: {
            get() {
                return this.$store.state.storeAdminBanner.currentTab
            },
            set(val) {
                return this.formData.position = val
            },
        },
    }
}
</script>
