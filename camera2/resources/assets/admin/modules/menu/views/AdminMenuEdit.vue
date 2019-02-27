<template>
    <b-modal
        :title="$t('textEditMenu')"
        v-model="openModalValue"
        @ok="submitModalEdit"
        @hidden="hideModalEdit"
        :centered="true" size="lg"
    >
        <b-row>
            <b-col sm="12">
                <b-form validated>
                    <b-row>
                        <b-col sm="12">
                            <b-form-fieldset :label="$t('textName')">
                                <b-form-input
                                    type="text" required
                                    :placeholder="$t('textName')"
                                    v-model.number="formData.name"
                                />
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
                        >
                        </b-form-input>
                    </b-form-fieldset>
                </b-form>
            </b-col><!--/.col-->
        </b-row>
        <div slot="modal-footer" class="w-100 text-center">
            <b-button type="submit" size="xs" variant="primary" @click="clickEditMenu">
                <i class="fa fa-dot-circle-o"></i>
                {{ $t('textSave') }}
            </b-button>
            <b-button type="reset" size="xs" variant="danger" @click="hideModalEdit">
                <i class="fa fa-ban"></i>
                {{ $t('textCancel') }}
            </b-button>
       </div>
    </b-modal>
</template>

<script>
import { STORAGE_AUTH } from '../store'

export default {
    name: 'AdminMenuEdit',

    props: {
        modalEdit: {
            type: Object,
            required: true
        },
        submitModalEdit: {
            type: Function,
            required: true
        },
        hideModalEdit: {
            type: Function,
            required: true
        },
    },

    methods: {
        clickEditMenu() {
            let params = this.formData

            if (!params.name || !params.path) {
                return this.$toaster.error(this.$i18n.t('textNotFillEnough'))
            }

            return this.submitModalEdit(this.formData.id, params)
        },
    },

    computed: {
        openModalValue: {
            get() {
                return this.modalEdit.open
            },
            set(val) {
            }
        },
        formData() {
            return {...this.modalEdit.formData}
        },
    }
}
</script>
