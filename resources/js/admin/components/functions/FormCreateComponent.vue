<template>
    <div id="form-create" class="form-create">

        <div id="create-form" class="modal fade form-create__modal" tabindex="-1">
            <div class="modal-dialog form-create__dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">

                       <span v-if="step === 1">Form Details</span>
                       <span v-if="step === 2">Select Input Type</span>
                       <span v-if="step === 3">Create {{ showInputType("", true) }} input</span>


                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body d-flex justify-content-between">

                    <div class="form-create__steps col-5">

                        <div class="alert alert-info border-bottom mb-0">
                            <p class="mb-0">Send To Email: {{ formEmail }}</p>
                        </div>


                    <!-- step one  -->
                        <div  v-if="step === 1" class="form-create__details">
                            <p>Lets start by entering the heading of the form and the email you want the form submission to be sent to.</p>
                            <div class="form-group">
                                <label for="form-email">Form Email</label>
                                <input v-model="formEmail" type="email" class="form-control" name="form_email" id="form-email">
                            </div>
                            <div class="form-group">
                                <label for="form-name">Form Heading</label>
                                <input v-model="formHeading" type="text" class="form-control" name="form_name" id="form-name">
                            </div>
                        </div>
                        <!-- step one  -->


                        <!-- step two-->

                            <div v-if="step === 2" class="form-create__creator form-group">

                                <p>Select the input that you want to add to this form group.</p>

                                <div class="form-create__container">

                                    <div class="form-create__options">

                                        <button @click.prevent="selectedInput" data-type="text" class="btn btn-info">Single Line</button>
                                        <button @click.prevent="selectedInput" data-type="email" class="btn btn-info">Email</button>
                                        <button @click.prevent="selectedInput" data-type="textarea" class="btn btn-info">Paragraph</button>

                                        <button @click.prevent="selectedInput" data-type="select" class="btn btn-info">Select</button>

                                        <button @click.prevent="selectedInput" data-type="checkbox" class="btn btn-info">Checkbox</button>
                                        <button @click.prevent="selectedInput" data-type="radio" class="btn btn-info">Radio</button>



                                        <button @click.prevent="selectedInput" data-type="number" class="btn btn-info">Number</button>

                                        <button @click.prevent="selectedInput" data-type="tel" class="btn btn-info">Phone</button>
                                        <button @click.prevent="selectedInput" data-type="address" class="btn btn-info">Address</button>


                                    </div>

                                </div>


                            </div>


                        <!-- step three  CUSTOMIZE INPUT FEATURES-->
                        <div v-if="step === 3" class="form-group pb-4 pt-0">

                            <p>Enter the label that you would like for this input. Labels appear above input.</p>



                        <!-- // TEXT Options features -->
                            <div class="mb-4" v-if="formInputType() === 'textType'">


                                <!-- make required  -->
                                    <div class="dynamic-btn__form-input my-4">

                                        <div class="custom-control custom-switch">
                                            <input @click="inputRequired = !inputRequired" type="checkbox" class="custom-control-input" id="required">
                                            <label class="custom-control-label" for="required">Input Required</label>
                                        </div>
                                    </div>

                                <label for="label">Enter Label &nbsp;<span class="text-danger"><em>(required)*</em></span></label>
                                <input v-model="inputLabel" type="text" class="form-control" id="label">

                                <label for="description">Enter Description &nbsp;<span class="text-secondary"><em>(optional)</em></span></label>
                                <textarea v-model="inputDescription" rows="2" class="form-control" id="description"></textarea>


                                <label for="placeholder">Enter Placeholder &nbsp;<span class="text-secondary"><em>(optional)</em></span></label>
                                <input type="text" v-model="inputPlaceholder" class="form-control" id="placeholder">

                            </div>

                        <!-- checkboxes and radios features  -->
                            <div v-if="formInputType() === 'checkboxType'">

                                <label for="heading">Enter Heading &nbsp;<span class="text-danger"><em>(required)*</em></span></label>
                                <input id="checkboxHeading" v-model="inputHeading" type="text" class="form-control">

                                <label for="number">Enter how many <span class="text-capitalize text-bold">{{ inputType }}</span>'s you need</label>
                                <p class="text-secondary"><em>Max 20</em></p>
                                <input @change="addCheckboxLabelDescriptionFields" class="form-control col-6" type="number" id="number" v-model="checkboxCount" min="1" max="20">

                                <div :id="checkboxInputs.indexOf(input)" v-for="input in checkboxInputs" :key="checkboxInputs.indexOf(input)">

                                    <label for="description">Enter Description &nbsp;<span class="text-secondary"><em>(optional)</em></span></label>
                                    <textarea v-model="input.description" rows="2" class="form-control" id="description"></textarea>


                                    <label for="label">Enter Label &nbsp;<span class="text-danger"><em>(required)*</em></span></label>
                                    <input v-model="input.label" type="text" class="form-control" id="label">

                                    <div v-if="checkboxCount > 1" class="border-bottom mb-2"></div>

                                </div>

                            </div>
                            <!-- ##/ checkboxes and radios  -->

                            <!-- Number features  -->


                            <div v-if="formInputType() === 'numberType'">


                                <label for="label">Enter Label &nbsp;<span class="text-danger"><em>(required)*</em></span>
                                </label>
                                <input v-model="inputLabel" type="text" class="form-control" id="label">


                                <label for="description">Enter Description &nbsp;<span class="text-secondary"><em>(optional)</em></span></label>
                                <textarea v-model="inputDescription" rows="2" class="form-control" id="description"></textarea>


                                <label for="minimum">Enter Minimum Value</label>
                                <p class="text-secondary"><em>minimum value a person may enter</em></p>
                                <input v-model="min" class="form-control col-6" type="number" id="minimum">

                                <label for="maximum">Enter Maximum Value</label>
                                <p class="text-secondary"><em>maximum value a person may enter</em></p>
                                <input v-model="max" class="form-control col-6" type="number" id="maximum">


                            </div>

                            <!-- ##/ number feathures  -->

                            <!-- Address Features  -->

                            <div v-if="formInputType() === 'addressType'">

                            <!-- make required  -->
                                <div class="dynamic-btn__form-input my-4">

                                    <div class="custom-control custom-switch">
                                        <input @click="inputRequired = !inputRequired" type="checkbox" class="custom-control-input" id="required">
                                        <label class="custom-control-label" for="required">Input Required</label>
                                    </div>
                                </div>

                                <label for="label">Enter Heading &nbsp;<span class="text-danger"><em>(required)*</em></span></label>
                                <input v-model="inputHeading" type="text" class="form-control" id="label">

                                <label for="description">Enter Description &nbsp;<span class="text-secondary"><em>(optional)</em></span></label>
                                <textarea v-model="inputDescription" rows="2" class="form-control" id="description"></textarea>

                            </div>
                            <!-- ##/ address features  -->


                            <!-- select features  -->

                            <div v-if="formInputType() === 'selectType'">

                                <label for="heading">Enter Heading &nbsp;<span class="text-danger"><em>(required)*</em></span></label>
                                <input id="checkboxHeading" v-model="inputHeading" type="text" class="form-control">

                                <label for="placeholder">Enter Placeholder &nbsp;<span class="text-secondary"><em>(optional)</em></span></label>
                                <input type="text" v-model="inputPlaceholder" class="form-control" id="placeholder">

                                <label for="number">Enter how many <span class="text-capitalize text-bold">Options</span>'s you need</label>
                                <p class="text-secondary"><em>Max 20</em></p>
                                <input @change="addSelectOptions" class="form-control col-6" type="number" id="number" v-model="selectCount" min="1" max="20">

                                <div :id="selectOptions.indexOf(input)" v-for="input in selectOptions" :key="selectOptions.indexOf(input)">

                                    <label for="label">Enter Option</label>
                                    <input v-model="input.option" type="text" class="form-control" id="label">

                                    <div v-if="selectCount > 1" class="border-bottom mb-2"></div>

                                </div>

                            </div>

                            <!-- ##/ select features  -->


                        <!-- make input dynamic  -->
                            <div v-if="formInputType() === 'textType'" class="dynamic-btn__form-input">

                                <div class="custom-control custom-switch">

                                    <input @click="inputDynamic = !inputDynamic" type="checkbox" class="custom-control-input" id="dynamic">
                                    <label class="custom-control-label" for="dynamic">Make Dynamic</label>

                                </div>

                                <div v-if="inputDynamic" class="mt-3">
                                    <input v-model="inputDynamicDescription" type="text" class="form-control" placeholder="Enter Label">
                                </div>

                            </div>



                        </div>



                    </div>
            <!-- ##/-- ============ steps ============ -->


                <!-- ===============================================================================================
                 FORM PREVIEW ==========================================================================================  -->

                    <div class="form-create__info col-7 border-left">

                        <h4 class="alert alert-primary">
                            <span v-if="step !== 3"> Form Preview </span>
                            <span v-else >Create {{ showInputType("", true) }} Input</span>
                        </h4>

                        <div class="clearfix">

                            <div v-if="step === 2" class="d-flex justify-content-between align-items-end mb-2 mt-4">
                                <button @click.prevent="editInput" class="btn btn-primary" :disabled="previewSelected !== 1">Edit Selected Input</button>
                                <div class="form-check">
                                    <label class="mr-2 mb-0" for="select-all">Select all</label>
                                    <input @click="selectAll" id="select-all" type="checkbox" class="form-checkbox mb-0" :disabled="!formHtml">
                                </div>

                            </div>

                            <div v-if="step === 3" class="form-check float-right">
                                <label for="hide-form">Hide form</label>
                                <input @click="hideForm = !hideForm" id="hide-form" type="checkbox" class="form-checkbox" :checked="hideForm">
                            </div>

                        </div>


                        <div class="border shadow-sm mb-4 p-2 form-create__preview">


                            <div v-if="!formHeading">
                                <p class="text-secondary">Your form will build here!</p>
                            </div>

                            <h4>{{ formHeading }}</h4>

                         <!-- main form preview -->
                            <div class="form-preview" v-if="!hideForm" v-html="formHtml"></div>

                        <!-- CREATE INPUT PREVIEW  -->
                            <div v-if="inputType" class="form-group">


                            <!-- text type  -->
                                <div v-if="formInputType(inputType) === 'textType'">

                                    <label>{{ inputLabel || 'Label' }} &nbsp;<span v-if="inputRequired" class="text-danger"><em>(required)*</em></span></label>

                                    <p class="text-secondary"><em>{{ inputDescription || 'Input Description' }}</em></p>

                                    <input class="form-control" v-if="inputType === 'text'" type="text" :placeholder="inputPlaceholder || 'placeholder'">

                                    <input class="form-control" v-if="inputType === 'email'" type="email" :placeholder="inputPlaceholder || 'placeholder'">

                                    <input class="form-control" v-if="inputType === 'tel'" type="tel"  pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" :placeholder="inputPlaceholder || 'placeholder'">

                                    <textarea v-if="inputType === 'textarea'" class="form-control" rows="3" :placeholder="inputPlaceholder || 'placeholder'"></textarea>

                                </div>
                                <!-- ##/- text type -->

                                <!-- checkbox type  -->
                                <div v-if="formInputType(inputType) === 'checkboxType'">

                                    <h5 v-if="inputHeading">{{ inputHeading}}</h5>
                                    <h5 v-else class="text-secondary">Heading</h5>

                                    <div class="my-4" :id="checkboxInputs.indexOf(input)" v-for="input in checkboxInputs" :key="checkboxInputs.indexOf(input)">
                                        <div class="mb-4 form-create__checkbox-wrapper">

                                            <p class="text-secondary mb-0"><em>{{ input.description || 'Description' }}</em></p>

                                            <div v-if="inputType === 'checkbox'" class="custom-checkbox custom-control">
                                                <input :id="'form-' + checkboxInputs.indexOf(input)" :type="inputType" class="custom-control-input" :name="inputHeading">
                                                <label class="custom-control-label" :for="'form-'+ checkboxInputs.indexOf(input)">{{ input.label || 'Label' }}</label>
                                            </div>

                                            <div v-if="inputType === 'radio'" class="custom-radio custom-control">
                                                <input :id="'form-' + checkboxInputs.indexOf(input)" :type="inputType" class="custom-control-input" :name="inputHeading">
                                                <label :for="'form-' + checkboxInputs.indexOf(input)" class="custom-control-label">{{input.label || 'Label'}}</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- ##/ checkbox type  -->



                            <!-- Number Type  -->
                                <div v-if="formInputType() === 'numberType'">

                                    <label for="minimum"><span class="text-capitalize text-bold">{{ inputLabel || 'Label' }}</span></label>
                                    <p class="text-secondary"><em>{{ inputDescription || 'Description' }}</em></p>
                                    <input :min="min"  :max="max" :value="min" class="form-control col-6" type="number">

                                </div>
                            <!-- ##/ number type  -->

                            <!-- Address type  -->
                                <div v-if="formInputType() === 'addressType'">

                                    <label for="address" v-if="inputHeading"><h6 class="d-inline">{{ inputHeading}}</h6> &nbsp;<span v-if="inputRequired" class="text-danger"><em>(required)*</em></span></label>
                                    <label v-else><h6 class="d-inline text-secondary">Heading</h6> &nbsp;<span v-if="inputRequired" class="text-danger"><em>(required)*</em></span></label>

                                    <p class="text-secondary"><em>{{ inputDescription || 'Input Description' }}</em></p>

                                    <label for="address">Address</label>

                                    <input id="address" class="form-control" type="text" name="address">

                                        <div class="form-row">
                                        <div class="col-md-6">
                                            <label for="city">City</label>
                                            <input type="text" class="form-control" id="city">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="state">State</label>
                                            <select id="state" class="form-control">
                                                <option selected hidden>Choose State</option>
                                                <option value="AL">Alabama</option>
                                                <option value="AK">Alaska</option>
                                                <option value="AZ">Arizona</option>
                                                <option value="AR">Arkansas</option>
                                                <option value="CA">California</option>
                                                <option value="CO">Colorado</option>
                                                <option value="CT">Connecticut</option>
                                                <option value="DE">Delaware</option>
                                                <option value="DC">District Of Columbia</option>
                                                <option value="FL">Florida</option>
                                                <option value="GA">Georgia</option>
                                                <option value="HI">Hawaii</option>
                                                <option value="ID">Idaho</option>
                                                <option value="IL">Illinois</option>
                                                <option value="IN">Indiana</option>
                                                <option value="IA">Iowa</option>
                                                <option value="KS">Kansas</option>
                                                <option value="KY">Kentucky</option>
                                                <option value="LA">Louisiana</option>
                                                <option value="ME">Maine</option>
                                                <option value="MD">Maryland</option>
                                                <option value="MA">Massachusetts</option>
                                                <option value="MI">Michigan</option>
                                                <option value="MN">Minnesota</option>
                                                <option value="MS">Mississippi</option>
                                                <option value="MO">Missouri</option>
                                                <option value="MT">Montana</option>
                                                <option value="NE">Nebraska</option>
                                                <option value="NV">Nevada</option>
                                                <option value="NH">New Hampshire</option>
                                                <option value="NJ">New Jersey</option>
                                                <option value="NM">New Mexico</option>
                                                <option value="NY">New York</option>
                                                <option value="NC">North Carolina</option>
                                                <option value="ND">North Dakota</option>
                                                <option value="OH">Ohio</option>
                                                <option value="OK">Oklahoma</option>
                                                <option value="OR">Oregon</option>
                                                <option value="PA">Pennsylvania</option>
                                                <option value="RI">Rhode Island</option>
                                                <option value="SC">South Carolina</option>
                                                <option value="SD">South Dakota</option>
                                                <option value="TN">Tennessee</option>
                                                <option value="TX">Texas</option>
                                                <option value="UT">Utah</option>
                                                <option value="VT">Vermont</option>
                                                <option value="VA">Virginia</option>
                                                <option value="WA">Washington</option>
                                                <option value="WV">West Virginia</option>
                                                <option value="WI">Wisconsin</option>
                                                <option value="WY">Wyoming</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="zip">Zip</label>
                                            <input type="text" class="form-control" id="zip">
                                        </div>
                                    </div>

                                </div>


                                <!-- select type  -->
                                <div v-if="formInputType(inputType) === 'selectType'">

                                    <h6 v-if="inputHeading">{{ inputHeading}}</h6>
                                    <h6 v-else class="text-secondary">Heading</h6>

                                    <select class="custom-select col-4">
                                        <option class="text-secondary" :value="inputPlaceholder" selected hidden disabled>{{inputPlaceholder || 'Placeholder'}}</option>
                                        <option v-for="input in selectOptions" :key="selectOptions.indexOf(input)" :value="input.option">{{ input.option }}</option>
                                    </select>

                                </div>

                                <!-- ##/ select type  -->


                            <!-- make input dynamic  -->
                                <div v-if="inputDynamic" class="dynamic-btn">
                                    <button class="btn btn-info dynamic-btn__btn">&plus;<small :class="{'dynamic-btn__text': inputDynamicDescription}">{{ inputDynamicDescription }}</small></button>
                                </div>

                            </div>
                                <!-- ##-end of input  -->

                        </div>

                         <div v-if="step === 2" class="d-flex justify-content-between">
                            <button @click.prevent="deleteSelected" class="btn btn-danger my-1" :disabled="!previewSelected">Delete Selected</button>
                            <button @click.prevent="createGroup" class="btn btn-primary ml-2 my-1" :disabled="previewSelected < 2">Group Selected</button>
                        </div>

                    </div>

                <!-- ##/--============== form input ===============-- -->

                </div>
                    <!-- ##/modal-body  -->
                <div class="modal-footer">
                    <div v-if="step === 1" class="form-create__footer-btns">

                        <button type="button" class="btn btn-danger btns__icon" data-dismiss="modal"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg> Cancel</button>

                        <button @click.prevent="next" type="button" class="btn btn-primary" :disabled="!enableStartBtn">Start <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right-circle"><circle cx="12" cy="12" r="10"></circle><polyline points="12 16 16 12 12 8"></polyline><line x1="8" y1="12" x2="16" y2="12"></line></svg></button>

                    </div>
                    <div v-if="step === 2" class="form-create__footer-btns">
                        <div>
                            <button type="button" class="btn btn-danger btns__icon" data-dismiss="modal"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg> Cancel</button>
                        </div>

                        <div>
                            <button @click.prevent="back" class="btn btn-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left-circle"><circle cx="12" cy="12" r="10"></circle><polyline points="12 8 8 12 12 16"></polyline><line x1="16" y1="12" x2="8" y2="12"></line></svg> Back</button>
                            <button @click.prevent="next" class="btn btn-primary" :disabled="!inputType">Create Form <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg></button>
                        </div>

                    </div>
                    <div v-if="step === 3" class="form-create__footer-btns">
                        <div>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg> Cancel</button>
                        </div>

                        <div>
                            <button @click.prevent="back" class="btn btn-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left-circle"><circle cx="12" cy="12" r="10"></circle><polyline points="12 8 8 12 12 16"></polyline><line x1="16" y1="12" x2="8" y2="12"></line></svg> Back</button>

                            <button @click.prevent="createInput" class="btn btn-primary" :disabled="!enableCreateInputBtn">Create Input <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg></button>

                        </div>


                    </div>
                </div>
                </div>
            </div>
        </div>


        <button @click.prevent data-toggle="modal" data-target="#create-form" class="btn btn-primary btns__icon">Create Form <span data-feather="file-plus" class="btns__icon--right"></span></button>


    </div><!-- ./form-create  -->



</template>

<script>

    import { muid } from '../../mixins/muid';
    const feather = require('feather-icons');


export default {

    mixins: [ 'muid' ],

    data() {
        return {
            checkboxCount: 1,
            checkboxInputs: [ {
                label: "",
                description: ""
            }, ],
            selectCount: 1,
            selectOptions: [ {
                option: ""
            } ],
            formHtml: "",
            formInputs: [],
            formHeading: null,
            formEmail: null,
            inputHeading: "",
            inputPlaceholder: "",
            inputType: null,
            inputLabel: null,
            inputDescription: null,
            inputDynamic: false,
            inputDynamicDescription: "",
            inputRequired: false,
            min: 0,
            max: 10,
            previewSelected: 0,
            step: 2,
            hideForm: false,
            editMode: false,
            editId: null,
        }
    },




    computed: {

    // removes disabled from start button when heading and email is filled out
        enableStartBtn() {
            return this.formHeading && this.formEmail ? true : false;
        },


    // removes disable from create input btn
        enableCreateInputBtn() {
            if(this.formInputType() === 'checkboxType') {

            // check if input label or heading exist
                if(this.inputLabel || this.inputHeading) {

                // return labels that are filled in
                    const labels = this.checkboxInputs.filter( input => {
                        return input.label !== "";
                    } );

                // check to see if the length is the same
                    return labels.length === this.checkboxInputs.length ? true : false;

                } else {
                    return false;
                }

            } else {
                return this.inputLabel || this.inputHeading ? true : false;
            }

        },


    },




    methods: {


        editInput() {

            const previewSelects = $('.preview-select-input');

            let id = "";



            $(previewSelects).each( ( i, input ) => {

                if($(input).prop('checked')) {

                    id = parseInt($(input).attr('id'));

                    return;

                }

            } );

            const input = this.formInputs[id];


            this.editMode = true;
            this.editId = id;

            this.checkboxCount = input.checkBoxes.length;
            this.checkboxInputs = input.checkBoxes;
            this.selectCount = input.selectOptions.length;
            this.selectOptions = input.selectOptions;
            this.inputHeading = input.heading;
            this.inputPlaceholder = input.placeholder;
            this.inputType = input.type;
            this.inputLabel = input.label;
            this.inputDynamic = input.dynamic;
            this.inputDescription = input.description;
            this.inputDynamicDescription = input.dynamicDescription;
            this.inputRequired = input.required;
            this.min = input.min;
            this.max = input.max;
            this.hideForm = true;

            this.step = 3;

        },




        // event select all
        selectAll(e) {
             const previewInputs = $(".preview-select-input");


            $(previewInputs).each( (i, input) => {
                $(input).prop('checked', $(e.target).prop('checked'));
            } );


            this.previewInputsSelected();

        },



        // event for when input is selected to enable buttons
        formInputSelectedEvent() {

            const previewInputs = $(".preview-select-input");

            $(previewInputs).each( ( i, input ) => {

                $(input).on('click', this.previewInputsSelected);

            } );

        },




        addCheckboxLabelDescriptionFields() {

            const inputs = {
                label: "",
                description: ""
            }


            // Add input object
                if(this.checkboxInputs.length < this.checkboxCount ) {
                    this.checkboxInputs.push(inputs);
                }


            // remove input object
                if(this.checkboxInputs.length > this.checkboxCount) {
                    this.checkboxInputs.pop();
                }


        },


        addSelectOptions() {

            const inputs = {
                name: "",
                value: ""
            }


            // Add input object
                if(this.selectOptions.length < this.selectCount ) {
                    this.selectOptions.push(inputs);
                }


            // remove input object
                if(this.selectOptions.length > this.selectCount) {
                    this.selectOptions.pop();
                }


        },




    // Events ============ /

        // Step Events
        back() {this.step--; this.reset()},
        next() {this.step++;},



        deleteSelected() {

            const deleteInput = confirm( "Are you sure you want to delete the selected inputs from the form?" );


            if(deleteInput) {

                const removeIds = [];

                $('.preview-select-input').each( ( i, psInput ) => {

                    if( $(psInput).prop('checked') ) {

                        const id = parseInt($(psInput).attr('id'));

                        removeIds.push(id);

                     }

                } );
                // ##/ end of loop

               this.formInputs = this.formInputs.filter( (input, i) => {
                    return removeIds.indexOf(i) == -1;
                } );

                this.createFormHtml();
                this.previewInputsSelected(true);

            }

        },




        createGroup() {

            const removeIds = []; // ids to filter later

            let   selectedInputs = [],
                  setPosition = true,
                  insertPosition = ""; // set form position

            $('.preview-select-input').each( ( i, psInput ) => {

                if( $(psInput).prop('checked') ) {

                    const id = parseInt($(psInput).attr('id')),
                          input = this.formInputs[id];

                // set insert position
                    if(setPosition) {
                        insertPosition = id;
                        setPosition = false;
                    }  // set formInput position

                    removeIds.push( id ); // add id's to remove from formInputs json

                // insert selected values
                    Array.isArray(input) ?
                        selectedInputs = selectedInputs.concat(input) :
                        selectedInputs.push( input );

                }

            } );
            // ##/ end of loop

           this.formInputs = this.formInputs.filter( (input, i) => {
               return removeIds.indexOf(i) == -1;
           } );


            this.formInputs.splice(insertPosition, 0, selectedInputs);

            this.createFormHtml();

            this.previewInputsSelected(true);

        },


    // Reset data when modal is dismissed
        resetDataModalDismiss() {
            $('#create-form').on('hidden.bs.modal', () => {
                this.reset(true);
            });
        },


    // Enter selected input type
        selectedInput(e) {

            this.inputType = $(e.target).attr('data-type');

            this.hideForm = true;

            this.next();

        },




    // Funcitons ============= /

// this will set options for the form input
        formInputType(inputType = this.inputType) {
        // return text type
            if (
                inputType === 'text' ||
                inputType === 'email' ||
                inputType === 'textarea' ||
                inputType === 'tel'
            ) {
                return 'textType';
            }

        // return checkbox type
            if(
                inputType === 'checkbox' ||
                inputType === 'radio'
            ) {
                return 'checkboxType';
            }

            // return checkbox type
            if(
                inputType === 'number'
            ) {
                return 'numberType';
            }

            // return address type
                if(
                    inputType === 'address'
                ) {
                    return 'addressType';
                }

            // return select type
                if(
                    inputType === 'select'
                ) {
                    return 'selectType';
                }

        },

// Create the main html form!
        createFormHtml() {

            let html = '';


            this.formInputs.forEach( (input, i) => {

                const showInputName = Array.isArray(input) ? 'group' : this.showInputType(input);


            // adds the select to the form
                    html += `<div class="form-check float-right form-create__preview-select preview-select">
                                <label class="form-check-label text-secondary" for="${i}">${showInputName}</label>
                                <input id="${i}" class="form-check-input form-create__preview-select-input preview-select-input" type="checkbox">
                            </div>`;


                // form group start div
                    html += '<div class="form-group">';


                        if(Array.isArray(input)) {

                            input.forEach( input => {


                            // remove make dynamic button if group
                                input.dynamic = false;
                                input.dynamicDescription = "";

                               html += this.inputCreate(input);

                            } );


                        } else {

                            html += this.inputCreate(input);

                        }

                    html += '</div>';

            } );


            this.formHtml = html;


        },

// This creates the inputs with labels and descriptions
        inputCreate(input) {

            let html = "";

            const inputType = this.formInputType(input.type),
                      required = input.required ? '&nbsp;<span class="text-danger"><em>(required)*</em></span>' : '',

                    descriptionHtml = input.description ? `<p class="text-secondary"><em>${input.description}</em></p>` : '',

                    dynamicBtnHtml = input.dynamicDescription ? `<div class="dynamic-btn">
                                        <button class="btn btn-info dynamic-btn__btn">&plus;<small class="dynamic-btn__text">${ input.dynamicDescription }</small></button>
                                    </div>` : "";


                    if(inputType === 'textType') {

                        html += `<label for="${input.name}">${input.label} ${required}</label>
                                ${descriptionHtml}
                                ${this.createInputHtml(input)}
                                ${dynamicBtnHtml}`;

                    }


                    if(inputType === 'checkboxType') {

                        html += `<h5>${input.heading}</h5>
                                 ${this.createCheckboxInputsHtml(input)}`;

                    }


                    if(inputType === 'numberType') {

                        html += `<label for="${input.name}">${input.label}</label>
                                    <p class="text-secondary"><em>${descriptionHtml}</em></p>
                                    ${this.createInputHtml(input)}`;

                    }


                    if(inputType === 'addressType') {

                        html += `<h5>${input.heading} ${required}</h5>
                                    <p class="text-secondary"><em>${descriptionHtml}</em></p>
                                    ${this.createInputHtml(input)}`;

                    }


                    if(inputType === 'selectType') {
                            html += `<h5>${input.heading}</h5>
                                ${this.createInputHtml(input)}`;

                    }

                    return html;

        },


        createCheckboxInputsHtml(input) {

            let html = ``;

            input.checkBoxes.forEach( checkbox => {

               const uid = muid();

                html += `<div class="my-4"><p class="text-secondary mb-0"><em>${checkbox.description}</em></p>
                        <div class="custom-control custom-${input.type}">
                            ${this.createInputHtml(input, uid, checkbox.label)}
                            <label class="custom-control-label" for="${uid}">${checkbox.label}</label>
                        </div></div>`;

            } );

            return html;

        },


// Create the input html from created inputs in the formInputs array
        createInputHtml(input, uid = muid(), checkboxLabel = "") {

            const required = input.required ? 'required' : '';

            let inputHtml = '';

            if( input.type === 'text'  ||
                input.type === 'email'  ) {

                inputHtml = `<input id="${input.name}" type="${input.type}" name="${input.name}" placeholder="${input.placeholder}" class="form-control mb-4" ${required}>`;

            }

            if (input.type === 'textarea') {

                inputHtml = `<textarea id="${input.name}" rows="5" name="${input.name}" class="form-control mb-4" placeholder="${input.placeholder}" ${required}></textarea>`;

            }


            if( input.type === 'number' ) {
                inputHtml = `<input id="${input.name}" type="${input.type}" class="form-control col-6 mb-4" value="${input.min}" name="${input.name}" min="${input.min}" max="${input.max}" ${required}>`;

            }


            if( input.type === 'tel' ) {
                inputHtml = `<input id="${input.name}" type="${input.type}" name="${input.name}" class="form-control mb-4" ${required}>`;
            }



            if( input.type === 'radio' || input.type === 'checkbox' ) {

                inputHtml = `<input id="${uid}" type="${input.type}" value="${checkboxLabel.toLowerCase()}" name="${this.getInputName(false, input)}" class="custom-control-input mb-4" id="${uid}" ${required}>`;

            }




            if(input.type === `address`) {

                inputHtml = `<label for="${input.name}_address">Address</label>
                            <input type="text" name="${input.name}_address" class="form-control" id="${input.name}_address" ${required}>

                            <div class="form-row mb-4">
                                <div class="form-group col-md-6">
                                <label for="${input.name}_city">City</label>
                                <input type="text" name="${input.name}_city" class="form-control" id="${input.name}_city" ${required}>
                                </div>
                                <div class="form-group col-md-4">
                                <label for="${input.name}_state">State</label>
                                 <select name="${input.name}_state" id="${input.name}_state" class="form-control" ${required}>
                                    <option selected hidden>Choose State</option>
                                    <option value="AL">Alabama</option>
                                    <option value="AK">Alaska</option>
                                    <option value="AZ">Arizona</option>
                                    <option value="AR">Arkansas</option>
                                    <option value="CA">California</option>
                                    <option value="CO">Colorado</option>
                                    <option value="CT">Connecticut</option>
                                    <option value="DE">Delaware</option>
                                    <option value="DC">District Of Columbia</option>
                                    <option value="FL">Florida</option>
                                    <option value="GA">Georgia</option>
                                    <option value="HI">Hawaii</option>
                                    <option value="ID">Idaho</option>
                                    <option value="IL">Illinois</option>
                                    <option value="IN">Indiana</option>
                                    <option value="IA">Iowa</option>
                                    <option value="KS">Kansas</option>
                                    <option value="KY">Kentucky</option>
                                    <option value="LA">Louisiana</option>
                                    <option value="ME">Maine</option>
                                    <option value="MD">Maryland</option>
                                    <option value="MA">Massachusetts</option>
                                    <option value="MI">Michigan</option>
                                    <option value="MN">Minnesota</option>
                                    <option value="MS">Mississippi</option>
                                    <option value="MO">Missouri</option>
                                    <option value="MT">Montana</option>
                                    <option value="NE">Nebraska</option>
                                    <option value="NV">Nevada</option>
                                    <option value="NH">New Hampshire</option>
                                    <option value="NJ">New Jersey</option>
                                    <option value="NM">New Mexico</option>
                                    <option value="NY">New York</option>
                                    <option value="NC">North Carolina</option>
                                    <option value="ND">North Dakota</option>
                                    <option value="OH">Ohio</option>
                                    <option value="OK">Oklahoma</option>
                                    <option value="OR">Oregon</option>
                                    <option value="PA">Pennsylvania</option>
                                    <option value="RI">Rhode Island</option>
                                    <option value="SC">South Carolina</option>
                                    <option value="SD">South Dakota</option>
                                    <option value="TN">Tennessee</option>
                                    <option value="TX">Texas</option>
                                    <option value="UT">Utah</option>
                                    <option value="VT">Vermont</option>
                                    <option value="VA">Virginia</option>
                                    <option value="WA">Washington</option>
                                    <option value="WV">West Virginia</option>
                                    <option value="WI">Wisconsin</option>
                                    <option value="WY">Wyoming</option>
                                </select>
                                </div>
                                <div class="form-group col-md-2">
                                <label for="${input.name}_zip">Zip</label>
                                <input type="text" name="${input.name}_zip" class="form-control" id="${input.name}_zip" ${required}>
                                </div>
                            </div>`;
            }



            if(input.type === 'select') {

                const placeHolder = input.placeholder ? `<option class="text-secondary" selected hidden disabled>${input.placeholder}</option>` : "";

                inputHtml = `<select name="${this.getInputName(true, input)}" class="mb-4 custom-select col-4 d-block">
                                    ${placeHolder}
                                    ${this.createOptionsHtml(input)}
                                </select>`;

            }


            return inputHtml;

        },

        createOptionsHtml(input) {

            let options = "";

            input.selectOptions.forEach( input => {

                options += `<option value="${input.option}">${input.option}</option>`;

            } );

            return options;

        },

// Creates or rather adds the input properties into an object and pushes the data into the form inputs array.
        createInput() {

            let input = {};

            input.checkBoxes = this.checkboxInputs;
            input.label = this.inputLabel;
            input.heading = this.inputHeading;
            input.placeholder = this.inputPlaceholder;
            input.type = this.inputType;
            input.dynamic = this.inputDynamic;
            input.dynamicDescription = this.inputDynamicDescription;
            input.description = this.inputDescription;
            input.required = this.inputRequired;
            input.max = this.max;
            input.min = this.min;
            input.selectOptions = this.selectOptions;


            input.name = this.getInputName(true);

            if (this.editMode) {

                this.formInputs[this.editId] = input;

            } else {

                this.formInputs.push(input);

            }


            this.reset();

            this.createFormHtml();

        },



        getInputName(uniqueId = false, input = "") {

                let name = "";

                if(!input) {

                    name = this.inputLabel ?
                                this.inputLabel.toLowerCase().replaceAll(" ", "_") :
                                this.inputHeading.toLowerCase().replaceAll(" ", "_");

                } else {

                    name = input.label ?
                                input.label.toLowerCase().replaceAll(" ", "_") :
                                input.heading.toLowerCase().replaceAll(" ", "_");

                }


                if (uniqueId) name += `_${muid()}`;

                return name;

        },

// increases count to access delete/group/selectall btns
        previewInputsSelected(reset = false) {

            if(reset && typeof reset !== 'object') {
                this.previewSelected = 0;
                $('#select-all').prop('checked', false);
                return;
            }

            const previewInputs = $(".preview-select-input");

            let count = 0;

            $(previewInputs).each( (i, select) => {
                if($(select).prop('checked')) {
                    count++;
                }
            } );

            this.previewSelected = count;

        },




// Reset the inputs properties. if ALL is true reset the entire form!
        reset(all = false) {

            if(all) {
                this.JsonForms = [];
                this.formHeading= null;
                this.formEmail = null;
                this.formHtml = "";
                this.formInputs = [];
            }

            this.checkboxCount = 1;
            this.checkboxInputs = [{
                label: "",
                description: ""
            },];
            this.selectCount = 1;
            this.selectOptions = [{
                    option: ""
                }, ];
            this.inputHeading = "";
            this.inputPlaceholder = "";
            this.inputType = null;
            this.inputLabel = null;
            this.inputDynamic = false;
            this.inputDescription = null;
            this.inputDynamicDescription = "";
            this.inputRequired = false;
            this.min = 0;
            this.max = 10;
            this.hideForm = false;
            this.editMode = false;
            this.editId = null;

            this.step = all ? 1 : 2;

            this.previewInputsSelected(true);
        },

        showInputType(input = '', capitalize = false) {

            const inputName = input ? input.type : this.inputType;

            let name = "";

            if(inputName === 'text') name = 'single line';

            if(inputName === 'email') name = 'email';

            if(inputName === 'textarea') name = 'paragraph';

            if(inputName === 'select') name = 'select';

            if(inputName === 'checkbox') name = 'checkbox';

            if(inputName === 'radio') name = 'radio';

            if(inputName === 'number') name = 'number';


            if(inputName === 'tel') name = 'phone';


            if(inputName === 'address') name = 'address';


            if(capitalize) name = name.charAt(0).toUpperCase() + name.slice(1);;


            return name;

        },


    }, // ##-METHODS ---/





    updated() {
        this.formInputSelectedEvent();
    }, // ##-UPDATED




    mounted() {
        this.resetDataModalDismiss(); // add the reset method to the cancel modal event
    }


}


</script>

<style>

</style>
