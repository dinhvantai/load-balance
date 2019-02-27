<template>
    <b-modal
        :title="$t('textEditCategory')"
        v-model="openModalValue"
        @ok="submitModalEdit"
        @hidden="hideModalEdit"
        :centered="true" size="lg"
    >
         <b-row>
            <b-col sm="12">
                <b-form validated>
                    <b-row>
                        <b-col sm="8">
                            <b-form-fieldset :label="$t('textName')">
                                <b-form-input 
                                    type="text" required
                                    :placeholder="$t('textName')" 
                                    v-model="formData.name"
                                />
                            </b-form-fieldset>
                        </b-col>
                        <b-col sm="4">
                            <b-form-fieldset :label="$t('textStatus')" class="text-center">
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
                        <b-col sm="8">
                            <b-form-fieldset :label="$t('textSlug')">
                                <b-form-input 
                                    type="text" required
                                    :placeholder="$t('textSlug')"
                                    v-model="formSlugName"
                                />
                            </b-form-fieldset>
                        </b-col>
                        <b-col sm="4">
                            <b-form-fieldset :label="$t('textPrioty')">
                                <b-form-input type="number" :placeholder="$t('textPrioty')" v-model.number="formData.prioty" />
                            </b-form-fieldset>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col sm="6">
                            <b-form-fieldset :label="$t('textParentCategory')">
                                <b-form-select
                                    :plain="true"
                                    :options="getParentCategoryOption"
                                    v-model.number="formData.parent_id"
                                />
                            </b-form-fieldset>
                        </b-col>
                        <b-col sm="6">
                            <b-form-fieldset :label="$t('textType')">
                                <b-form-select
                                    :plain="true" required
                                    :options="optionTypeCategory"
                                    v-model="formData.type"
                                >
                                </b-form-select>
                            </b-form-fieldset>
                        </b-col>
                    </b-row>
                    <b-form-fieldset :label="$t('textDescription')">
                        <b-form-input
                            v-model="formData.description"
                            :placeholder="$t('textDescription')"
                        />
                    </b-form-fieldset>
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
            <b-button type="submit" size="xs" variant="primary" @click="clickSubmitEdit">
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
import cSwitch from 'assets/components/Switch.vue'

import { ADMIN_CATEGORY_TYPE_OPTION, CATEGORY_STATUS_SHOW } from '../store'

export default {
    name: 'AdminCategoryEdit',

    components: { cSwitch },

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
        parentCategoryOption: {
            type:Array,
            required: true
        }
    },

    data() {
        return {
            optionTypeCategory: ADMIN_CATEGORY_TYPE_OPTION.map(option => (
                { value: option.value, text: this.$i18n.t(option.text) }
            )),
        }
    },

    methods: {
        clickSubmitEdit() {
            let params = this.formData

            params.parent_id = params.parent_id ? params.parent_id : 0;
            
            if (!params.name || !params.slug || !params.type) {
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
            let formData = this.modalEdit.formData
            
            return formData
        },

        formSlugName: {
            get() {
                return this.formData.slug
            },
            set(val) {
                return this.formData.slug = val
            }
        },

        getParentCategoryOption() {
            return this.parentCategoryOption.filter((option) => {
                return option.value != this.modalEdit.formData.id
            })
        }
    }
}
</script>
