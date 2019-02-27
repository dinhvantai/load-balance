<template>
    <b-modal
        :title="$t('textAddCategory')"
        v-model="openModalValue"
        @ok="submitModalAdd"
        @hidden="hideModalAdd"
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
                                    @input="handleChangeName"
                                />
                            </b-form-fieldset>
                        </b-col>
                        <b-col sm="4" class="text-center">
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
                        <b-col sm="8">
                            <b-form-fieldset :label="$t('textSlug')">
                                <b-form-input 
                                    type="text" required
                                    :placeholder="$t('textSlug')" 
                                    v-model="formData.slug" 
                                />
                            </b-form-fieldset>
                        </b-col>
                        <b-col sm="4">
                            <b-form-fieldset :label="$t('textPrioty')">
                                <b-form-input 
                                    type="number" :placeholder="$t('textPrioty')" 
                                    v-model.number="formData.prioty" 
                                />
                            </b-form-fieldset>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col sm="6">
                            <b-form-fieldset :label="$t('textParentCategory')">
                                <b-form-select
                                    :plain="true"
                                    :options="parentCategoryOption"
                                    v-model.number="formData.parent_id"
                                />
                            </b-form-fieldset>
                        </b-col>
                        <b-col sm="6">
                            <b-form-fieldset :label="$t('textType')">
                                <b-form-select
                                    :plain="true" required
                                    :options="optionTypeCategory"
                                    v-model="formDataType"
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
            <b-button type="submit" size="xs" variant="primary" @click="clickAddItem">
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

import { ADMIN_CATEGORY_TYPE_OPTION } from '../store'

export default {
    name: 'AdminCategoryAdd',

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
        parentCategoryOption: {
            type:Array,
            required: true
        },
    },

    data() {
        return {
            optionTypeCategory: ADMIN_CATEGORY_TYPE_OPTION.map(option => (
                { value: option.value, text: this.$i18n.t(option.text) }
            )),
            formData: this.resetFormData(),
        }
    },

    methods: {
        resetFormData() {
            return this.formData = {
                name: '',
                slug: '',
                status: true,
                prioty: 0,
                parent_id: '',
                type: this.$store.state.storeAdminCategory.currentTab,                
                description: '',
                seo_keyword: '',
                seo_description: '',
            }
        },

        clickAddItem() {
            let params = { ...this.formData }

            if (!params.name || !params.slug || !params.type) {
                return this.$toaster.error(this.$i18n.t('textNotFillEnough'))
            }

            this.resetFormData()

            return this.submitModalAdd(params)
        },

        handleChangeName() {
            return this.formData.slug = slug(this.formData.name.toLowerCase())
        },
    },

    computed: {
        openModalValue: {
            get() {
                return this.modalAdd.open
            },
            set(val) {},
        },

        formDataType: {
            get() {
                return this.$store.state.storeAdminCategory.currentTab
            },
            set(val) {
                return this.formData.type = val
            },
        }, 
    },
}
</script>
