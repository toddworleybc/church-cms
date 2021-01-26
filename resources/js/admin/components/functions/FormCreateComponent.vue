<template>
    <div id="form-create" class="form-create">

        <div id="create-form" class="modal fade form-create__modal" tabindex="-1">
            <div class="modal-dialog form-create__dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">

                       <span v-if="step === 1">Form Details</span>
                       <span v-if="step === 2">Select Input Type</span>
                       <span v-if="step === 3">Input Labels</span>


                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body d-flex justify-content-between">

                    <div class="form-create__steps col-5">

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

                                        <!-- <button @click.prevent="selectedInput" data-type="select" class="btn btn-info">Select</button> -->

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


                                    <label for="label">Enter Label</label>
                                    <input v-model="input.label" type="text" class="form-control" id="label">

                                    <div v-if="checkboxCount > 1" class="border-bottom mb-2"></div>

                                </div>


                                <div class="custom-control custom-switch">

                                    <input @click="checkboxesInline = !checkboxesInline" type="checkbox" class="custom-control-input" id="checkboxes-inline" :checked="checkboxesInline">
                                    <label class="custom-control-label" for="checkboxes-inline">Make Checkboxes Inline</label>

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

                        <div class="alert alert-info border-bottom">
                            <p class="mb-0">Send To Email: {{ formEmail }}</p>
                        </div>

                    </div>
            <!-- ##/-- ============ steps ============ -->


                <!-- FORM PREVIEW  -->
                    <div class="form-create__info col-7 border-left">

                        <h4 class="alert alert-info">
                            <span v-if="step !== 3"> Form Preview </span>
                            <span v-else >Create Input</span>
                        </h4>

                        <div class="border shadow-sm mb-4 p-2 form-create__preview">


                            <div v-if="!formHeading">
                                <p class="text-secondary">Your form will build here!</p>
                            </div>

                            <h5>{{ formHeading }}</h5>

                         <!-- main form preview -->
                            <div v-html="formHtml"></div>

                        <!-- CREATE INPUT PREVIEW  -->
                            <div v-if="inputType" class="form-group">


                            <!-- text type  -->
                                <div v-if="formInputType(inputType) === 'textType'">

                                    <label :class="{'text-secondary' : !inputLabel}" for="">{{ inputLabel || 'Label' }} &nbsp;<span v-if="inputRequired" class="text-danger"><em>(required)*</em></span></label>

                                    <p class="text-secondary"><em>{{ inputDescription || 'Input Description' }}</em></p>

                                    <input class="form-control" v-if="inputType === 'text'" type="text" :placeholder="inputPlaceholder || 'placeholder'">

                                    <input class="form-control" v-if="inputType === 'email'" type="email" :placeholder="inputPlaceholder || 'placeholder'">

                                    <input class="form-control" v-if="inputType === 'tel'" type="tel"  pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" :placeholder="inputPlaceholder || 'placeholder'">

                                    <textarea v-if="inputType === 'textarea'" class="form-control" rows="3" :placeholder="inputPlaceholder || 'placeholder'"></textarea>

                                </div>
                                <!-- ##/- text type -->

                                <!-- checkbox type  -->
                                <div v-if="formInputType(inputType) === 'checkboxType'">

                                    <h6 v-if="inputHeading">{{ inputHeading}}</h6>
                                    <h6 v-else class="text-secondary">Heading</h6>

                                    <div class="my-4" :id="checkboxInputs.indexOf(input)" v-for="input in checkboxInputs" :key="checkboxInputs.indexOf(input)">
                                        <div class="mb-4 form-create__checkbox-wrapper">

                                            <p class="text-secondary mb-0"><em>{{ input.description || 'Description' }}</em></p>

                                            <div v-if="inputType === 'checkbox'" class="custom-checkbox custom-control">
                                                <input :id="'form-' + checkboxInputs.indexOf(input)" :type="inputType" class="custom-control-input">
                                                <label class="custom-control-label" :for="'form-'+ checkboxInputs.indexOf(input)">{{ input.label }}</label>
                                            </div>

                                            <div v-if="inputType === 'radio'" class="custom-radio custom-control">
                                                <input :id="'form-' + checkboxInputs.indexOf(input)" :type="inputType" class="custom-control-input">
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


                            <!-- make input dynamic  -->
                                <div v-if="inputDynamic" class="dynamic-btn">
                                    <button class="btn btn-info dynamic-btn__btn">&plus;<small :class="{'dynamic-btn__text': inputDynamicDescription}">{{ inputDynamicDescription }}</small></button>
                                </div>

                            </div>
                                <!-- ##-end of input  -->

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

                            <!-- <button v-if="formInputType() === 'checkboxType'" @click.prevent="createInput" class="btn btn-primary" :disabled="!enableCreateInputBtn">Create Input <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg></button>

                            <button v-if="formInputType() === 'numberType'" @click.prevent="createInput" class="btn btn-primary" :disabled="!enableCreateInputBtn">Create Input <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg></button> -->

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
            checkboxesInline: true,
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
            step: 2,
        }
    },




    computed: {

    // removes disabled from start button when heading and email is filled out
        enableStartBtn() {
            return this.formHeading && this.formEmail ? true : false;
        },


    // removes disable from create input btn
        enableCreateInputBtn() {
            return this.inputLabel || this.inputHeading ? true : false;
        },



    },




    methods: {


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




    // Events ============ /

        // Step Events
        back() {this.step--; this.reset()},
        next() {this.step++;},




    // Reset data when modal is dismissed
        resetDataModalDismiss() {
            $('#create-form').on('hidden.bs.modal', () => {
                this.reset(true);
            });
        },

    // Enter selected input type
        selectedInput(e) {

            this.inputType = $(e.target).attr('data-type');

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

        },

// Create the main html form!
        createFormHtml() {

            let html = '';


            this.formInputs.forEach( input => {


                const inputType = this.formInputType(input.type),
                      required = input.required ? '&nbsp;<span class="text-danger"><em>(required)*</em></span>' : '',

                    descriptionHtml = input.description ? `<p class="text-secondary"><em>${input.description}</em></p>` : '',

                    dynamicBtnHtml = input.dynamicDescription ? `<div class="dynamic-btn">
                                        <button class="btn btn-info dynamic-btn__btn">&plus;<small class="dynamic-btn__text">${ input.dynamicDescription }</small></button>
                                    </div>` : "";


                    if(inputType === 'textType') {

                        html += `<div class="form-group">
                                <label for="${input.name}">${input.label} ${required}</label>
                                ${descriptionHtml}
                                ${this.createInputHtml(input)}
                                ${dynamicBtnHtml}
                            </div>`;

                    }


                    if(inputType === 'checkboxType') {

                        html += `<div class="form-group">
                                    <h6>${input.heading}</h6>
                                    ${this.createCheckboxInputsHtml(input)}
                                    ${dynamicBtnHtml}
                                </div>`;

                    }


                    if(inputType === 'numberType') {

                        html += `<div class="form-group"><label for="${input.name}"><span class="text-capitalize text-bold">${input.label}</span></label>
                                    <p class="text-secondary"><em>${input.description}</em></p>
                                    ${this.createInputHtml(input)}</div>`;

                    }


                    if(inputType === 'addressType') {

                        html += `<div class="form-group">
                                    <label><h6 class="d-inline">${input.heading}</h6> &nbsp;<span class="text-danger"><em>(required)*</em></span></label>
                                    <p class="text-secondary"><em>${input.description}</em></p>
                                    ${this.createInputHtml(input)}
                                </div>`;

                    }

            } );


            this.formHtml = html;

        },

        createCheckboxInputsHtml(input) {

            let html = ``;

            input.checkBoxes.forEach( checkbox => {

               const uid = muid();

                html += `<div class="mb-4"><p class="text-secondary mb-0"><em>${checkbox.description}</em></p>
                        <div class="custom-control custom-${input.type}">
                            ${this.createInputHtml(input, uid)}
                            <label class="custom-control-label" for="${uid}">${checkbox.label}</label>
                        </div></div>`;

            } );

            return html;

        },


// Create the input html from created inputs in the form inputs array
        createInputHtml(input, uid = muid()) {

            const required = input.required ? 'required' : '';

            let inputHtml = '';

            if( input.type === 'text'  ||
                input.type === 'email'  ) {

                inputHtml = `<input id="${input.name}" type="${input.type}" name="${input.name}" placeholder="${input.placeholder}" class="form-control" ${required}>`;

            }

            if (input.type === 'textarea') {

                inputHtml = `<textarea id="${input.name}" rows="5" name="${input.name}" class="form-control" placeholder="${input.placeholder}" ${required}></textarea>`;

            }


            if( input.type === 'number' ) {
                inputHtml = `<input id="${input.name}" type="${input.type}" class="form-control col-6" value="${input.min}" name="${input.name}" min="${input.min}" max="${input.max}" ${required}>`;

            }


            if( input.type === 'tel' ) {
                inputHtml = `<input id="${input.name}" type="${input.type}" name="${input.name}" class="form-control" ${required}>`;
            }



            if( input.type === 'radio' || input.type === 'checkbox' ) {

                inputHtml = `<input id="${input.name}" type="${input.type}" name="${input.name}" class="custom-control-input" id="${uid}" ${required}>`;

            }




            if(input.type === `address`) {

                inputHtml = `<label for="${input.name}_address">Address</label>
                            <input type="text" name="${input.name}_address" class="form-control" id="${input.name}_address" ${required}>

                            <div class="form-row">
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



            return inputHtml;


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


            input.name = this.inputLabel ?
                                this.inputLabel.toLowerCase().replace(" ", "_") :
                                this.inputHeading.toLowerCase().replace(" ", "_");

        // make input name unique
            input.name = `${input.name}_${muid()}`;


            this.formInputs.push(input);

            this.reset();

            this.createFormHtml();

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

            this.step = all ? 1 : 2;
        },


    }, // ##-METHODS ---/





    updated() {

    }, // ##-UPDATED




    mounted() {
        this.resetDataModalDismiss(); // add the reset method to the cancel modal event
    }


}


</script>

<style>

</style>
