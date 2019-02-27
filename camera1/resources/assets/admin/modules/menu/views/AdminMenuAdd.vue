<template>
    <b-modal
        :title="$t('textAddMenu')"
        v-model="openModalValue"
        @ok="submitModalAdd"
        @hidden="hideModalAdd"
        :centered="true" size="lg"
    >
        <b-row>
            <b-col sm="12">
                <b-form validated>
                    <b-row>
                        <b-col sm="12">
                            <b-form-fieldset :label="$t('textName')">
                                <b-form-input type="text" :placeholder="$t('textName')" v-model="formData.name" required />
                            </b-form-fieldset>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col sm="6">
                            <b-form-fieldset :label="$t('textLink')">
                                <b-form-input
                                    type="text" required
                                    :placeholder="$t('textLink')"
                                    v-model="formData.path"
                                />
                            </b-form-fieldset>
                        </b-col>
                        <b-col sm="6">
                            <b-form-fieldset :label="$t('textPrioty')">
                                <b-form-input type="number" :placeholder="$t('textPrioty')" v-model.number="formData.prioty" />
                            </b-form-fieldset>
                        </b-col>
                    </b-row>
                    <b-form-fieldset :label="$t('textDescription')">
                        <b-form-input
                            v-model="formData.description"
                            :placeholder="$t('textDescription')"
                        />
                    </b-form-fieldset>
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
import { STORAGE_AUTH } from '../store'

export default {
    name: 'AdminMenuAdd',

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
        return {
            formData: this.resetFormData()
        }
    },

    methods: {
        resetFormData() {
            return this.formData = {
                name: '',
                prioty: 0,
                description: '',
                path: '',
                icon: '',
            }
        },

        clickAddMenu() {
            let params = this.formData

            if (!params.name || !params.path) {
                return this.$toaster.error(this.$i18n.t('textNotFillEnough'))
            }

            this.resetFormData()
            
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
        }
    }
}
</script>
