<template>
    <div id="form-create" class="form-create">

        <div id="create-form" class="modal fade form-create__modal" tabindex="-1">
            <div class="modal-dialog form-create__dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">

                       <span v-if="step === 1">Form Details</span>
                       <span v-if="step === 2">Select Input Type</span>
                       <span v-if="step === 3">{{ editMode ? 'Edit' : 'Create' }} {{ showInputType("", true) }} input</span>


                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body d-flex justify-content-between">

                    <div class="form-create__steps col-5">

                    <!-- step one  -->
                        <div  v-if="step === 1" class="form-create__details">
                            <p>Let's start creating your new form by entering the <span class="font-weight-bold">HEADING</span> for this form and the <span class="font-weight-bold">EMAIL</span> that you want this form to send to.</p>
                            <div class="form-group">
                                <label for="form-email">Form Email</label>
                                <input v-model="formEmail" type="email" class="form-control" name="form_email" id="form-email">
                                <div v-if="step === 1" class="alert alert-info border-bottom mb-0">
                                    <p class="mb-0">Send To Email: {{ formEmail }}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="form-name">Form Heading</label>
                                <input v-model="formHeading" type="text" class="form-control" name="form_name" id="form-name">
                            </div>
                        </div>
                        <!-- step one  -->


                        <!-- step two-->

                            <div v-if="step === 2" class="form-create__creator pt-3">

                                <p>Select the <span class="font-weight-bold">INPUT</span> that you want to add to the form.</p>


                                <div class="form-create__container border-tb">

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

                                        <button @click.prevent="selectedInput" data-type="payment" class="btn btn-info" :disabled="paymentAdded">Payment</button>

                                    </div>

                                </div>

                                 <div v-if="step > 1" class="alert alert-info mt-3">
                                    <p class="mb-0">Send To Email: {{ formEmail }}</p>
                                </div>


                            </div>


                        <!-- step three  CUSTOMIZE INPUT FEATURES-->

                        <div id="inputInfoInsert" v-html="infoHtml" v-if="inputInfoMode && step === 3" class="form-group pb-4"></div>

                        <div v-if="step === 3 && !inputInfoMode" class="form-group pb-4">

                                <p>Enter the options for the input type <span class="font-weight-bold text-capitalize">{{ showInputType() }}</span></p>

                                <div :class="{'form-create__disable-inputs form-create__disable-inputs--white' : showHiddenForm}">

                            <!-- GROUP TYPE  -->
                                <div class="mb-4" v-if="formInputType() === 'groupType'">


                                    <label for="heading">Enter Heading &nbsp;<span class="text-secondary"><em>(optional)</em></span></label>
                                    <input id="checkboxHeading" v-model="groupDetails.heading" type="text" class="form-control">

                                    <label for="description">Enter Description &nbsp;<span class="text-secondary"><em>(optional)</em></span></label>
                                    <textarea v-model="groupDetails.description" rows="2" class="form-control" id="description"></textarea>


                                </div>

                                <!-- ##/ end of group  -->

                                <!-- payment type  -->
                                <div class="mb-4" v-if="formInputType() === 'paymentType'">

                                    <!-- make required  -->
                                    <div class="dynamic-btn__form-input my-4">

                                        <div class="custom-control custom-switch">
                                            <input @click="inputRequired = !inputRequired" type="checkbox" class="custom-control-input" id="required">
                                            <label class="custom-control-label" for="required">Input Required</label>
                                        </div>
                                    </div>


                                    <label for="label">Enter Label &nbsp;<span class="text-secondary"><em>(optional)</em></span></label>
                                    <input v-model="inputLabel" type="text" class="form-control" id="label">

                                    <label for="description">Enter Description &nbsp;<span class="text-secondary"><em>(optional)</em></span></label>
                                    <textarea v-model="inputDescription" rows="2" class="form-control" id="description"></textarea>


                                    <label for="total">Enter Total &nbsp;<span class="text-danger"><em>(required)*</em></span></label>
                                    <input @change="calPrice" data-price-type="user-input" id="total" class="form-control col-4" v-model="inputTotal" type="number" name="total">


                                    <div class="custom-control custom-switch mb-4">
                                        <input @click="addQuantityInput" type="checkbox" class="custom-control-input" id="quanityInput" :checked="addQuantity">
                                        <label class="custom-control-label" for="quanityInput">Add Quanity</label>
                                    </div>

                                    <div v-if="addQuantity" class="mt-3">
                                        <input class="form form-control" v-model="quanityInputLabel" type="text">
                                    </div>


                                    <label for="pb-text">Button Text &nbsp;<span class="text-secondary"><em>(optional)</em></span></label>
                                    <input v-model="inputPbText" id="pb-text" type="text" class="form-control">



                                </div>
                                <!-- ##/ end of payment type  -->


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

                                    <div :id="`checkbox-${i}`" v-for="(input, i) in checkboxInputs" :key="i">

                                        <label :for="`description-${i}`">Enter Description &nbsp;<span class="text-secondary"><em>(optional)</em></span></label>
                                        <textarea v-model="input.description" rows="2" class="form-control" :id="`description-${i}`"></textarea>


                                        <label :for="`label-${i}`">Enter Label &nbsp;<span class="text-danger"><em>(required)*</em></span></label>
                                        <input v-model="input.label" type="text" class="form-control" :id="`label-${i}`">

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
                                <div v-if="dynamicControl" class="dynamic-btn__form-input">

                                    <div v-if="formInputType() === 'textType'">

                                        <div class="custom-control custom-switch">

                                            <input @click="inputDynamic = !inputDynamic" type="checkbox" class="custom-control-input" id="dynamic" :checked="inputDynamic">
                                            <label class="custom-control-label" for="dynamic">Make Dynamic &nbsp;<span class="text-secondary"><em>(optional)</em></span></label>

                                        </div>

                                        <div v-if="inputDynamic" class="mt-3">
                                            <input v-model="inputDynamicDescription" type="text" class="form-control" placeholder="Enter Button Label">
                                        </div>

                                    </div>


                                    <div v-if="formInputType() === 'groupType'">

                                        <div class="custom-control custom-switch">

                                            <input @click="groupDetails.groupDynamic = !groupDetails.groupDynamic" type="checkbox" class="custom-control-input" id="dynamic" :checked="groupDetails.groupDynamic">
                                            <label class="custom-control-label" for="dynamic">Make Dynamic</label>

                                        </div>

                                        <div v-if="groupDetails.groupDynamic" class="mt-3">
                                            <input v-model="groupDetails.groupDynamicDescription" type="text" class="form-control" placeholder="Enter Label">
                                        </div>


                                    </div>

                                </div>

                            </div><!-- disabled  -->
                        </div>


                        <button key="infoBtn" @click.prevent="inputInfo" v-if="step === 3 && !inputInfoMode" id="input-info" :data-type="inputType" class="btn btn-info btn-sm float-right btns__icon"><span data-feather="info"></span> Input Info</button>

                        <button key="backInfoBtn" @click.prevent="inputInfoMode = false" v-if="inputInfoMode" class="btn btn-secondary btn-sm float-right btns__icon"><span data-feather="arrow-left-circle"></span> Back</button>

                    </div>
            <!-- ##/-- ============ steps ============ -->


<!--=====================FORM PREVIEW=============================================== -->
<!--=====================FORM PREVIEW=============================================== -->
<!--=====================FORM PREVIEW=============================================== -->
<!--=====================FORM PREVIEW=============================================== -->


                    <div class="form-create__info col-7 border-left">

                        <h4 class="alert alert-primary">
                            <span v-if="step !== 3"> Form Preview </span>
                            <span v-else >{{ editMode ? "Edit" : 'Create' }} {{ showInputType("", true) }} Input</span>
                        </h4>

                        <div class="clearfix">

                            <div v-if="step === 2" class="d-flex justify-content-between align-items-end mb-2 mt-4">
                                <button @click.prevent="editInput" class="btn btn-primary btn-sm" :disabled="previewSelected !== 1">Edit Selected Input</button>
                                <div class="form-check">
                                    <label class="mr-2 mb-0 form-create__pointer" for="select-all">Select all</label>
                                    <input @click="selectAll" id="select-all" type="checkbox" class="form-checkbox mb-0 form-create__pointer" :disabled="!formHtml">
                                </div>

                            </div>

                            <div v-if="step === 3" class="form-check float-right">

                                <label for="hide-form" class="form-create__pointer">Show Input In Form</label>
                                <input @click="showForm" id="hide-form" type="checkbox" class="form-checkbox form-create__pointer" :disabled="!formHtml">

                            </div>

                        </div>


                        <div class="border shadow-sm mb-4 form-create__preview">


                            <div v-if="!formHeading">
                                <p class="text-secondary">Your form will build here...</p>
                            </div>

                            <h4>{{ formHeading }}</h4>

                         <!-- main form preview -->
                            <div class="form-preview" v-if="!formHidden" v-html="formHtml"></div>

                            <div class="form-preview" v-if="showHiddenForm" v-html="showFormHtml"></div>


                        <!-- CREATE INPUT PREVIEW -->
                            <div v-if="inputType && !showHiddenForm" class="form-group">

                                <!-- payment type  -->

                                <div v-if="formInputType() === 'paymentType'">

                                    <label v-if="inputLabel">{{ inputLabel }}</label>
                                    <label v-else class="text-secondary">Payment Heading</label>

                                    <p class="text-secondary"><em>{{ inputDescription || 'Payment Description' }}</em></p>



                                    <div class="my-3">
                                        <div class="form-check">
                                            <input id="credit" name="paymentMethod" value="credit" type="radio" class="form-check-input" checked required>
                                            <label class="form-check-label" for="credit">Credit card</label>
                                        </div>
                                        <div class="form-check">
                                            <input id="debit" name="paymentMethod" type="radio" class="form-check-input" value="debit" required>
                                            <label class="form-check-label" for="debit">Debit card</label>
                                        </div>
                                    </div>


                                    <p v-if="inputRequired" class="text-danger"><em> All payment fields are (required)*</em></p>


                                    <div class="row gy-3">

                                        <div class="col-md-6">
                                            <label for="cc-name" class="form-label">Name on card</label>

                                            <input type="text" class="form-control" id="cc-name" placeholder="" required>

                                            <div class="invalid-feedback">
                                                Name on card is required
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="cc-number" class="form-label">Credit card number</label>
                                            <input type="text" class="form-control" id="cc-number" placeholder="" required>
                                            <div class="invalid-feedback">
                                                Credit card number is required
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="cc-expiration" class="form-label">Expiration</label>
                                            <input type="text" class="form-control" id="cc-expiration" placeholder="" required>
                                            <div class="invalid-feedback">
                                                Expiration date required
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="cc-cvv" class="form-label">CVV</label>
                                            <input type="text" class="form-control" id="cc-cvv" placeholder="" required>
                                            <div class="invalid-feedback">
                                                Security code required
                                            </div>
                                        </div>
                                    </div>

                                    <div v-if="addQuantity" class="mb-2">
                                        <label for="addQuantity">{{ quanityInputLabel }}</label>
                                        <input @change="calPrice" data-price-type="quantity-input" name="addQuantity" class="form-control col-6" type="number" min="1" max="50" value="1" id="addQuantity">
                                    </div>

                                    <div class="clearfix mb-2">
                                        <div class="float-right"><p><strong>Total: </strong>${{ showPrice }}</p></div>
                                    </div>

                                </div>

                            <!-- ##/ payment type  -->


                            <!-- group type  -->
                                <div v-if="formInputType(inputType) === 'groupType'">
                                    <label v-if="groupDetails.heading">{{ groupDetails.heading }}</label>
                                    <label v-else class="text-secondary">Group Heading</label>

                                    <p class="text-secondary"><em>{{ groupDetails.description || 'Group Description' }}</em></p>

                                    <div v-html="groupInputsHtml"></div>

                                </div>
                                <!-- ##/ group type  -->

                            <!-- text type  -->
                                <div v-if="formInputType(inputType) === 'textType'">
                                    <!-- marked as label  -->
                                    <label v-if="inputLabel">{{ inputLabel }} &nbsp;<span v-if="inputRequired" class="text-danger"><em>(required)*</em></span></label>
                                    <label v-else class="text-secondary">Label &nbsp;<span v-if="inputRequired" class="text-danger"><em>(required)*</em></span></label>

                                    <p class="text-secondary"><em>{{ inputDescription || 'Input Description' }}</em></p>

                                    <input class="form-control" v-if="inputType === 'text'" type="text" :placeholder="inputPlaceholder || 'placeholder'">

                                    <input class="form-control" v-if="inputType === 'email'" type="email" :placeholder="inputPlaceholder || 'placeholder'">

                                    <input class="form-control" v-if="inputType === 'tel'" type="tel"  pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" :placeholder="inputPlaceholder || 'placeholder'">

                                    <textarea v-if="inputType === 'textarea'" class="form-control" rows="3" :placeholder="inputPlaceholder || 'placeholder'"></textarea>

                                </div>
                                <!-- ##/- text type -->

                                <!-- checkbox type  -->
                                <div v-if="formInputType(inputType) === 'checkboxType'">
                                    <!-- marked as heading  -->
                                    <label v-if="inputHeading">{{ inputHeading}}</label>
                                    <label v-else class="text-secondary">Heading</label>

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

                                    <label v-if="inputLabel">{{ inputLabel}}</label>
                                    <label v-else class="text-secondary">Label</label>

                                    <p class="text-secondary"><em>{{ inputDescription || 'Description' }}</em></p>
                                    <input :min="min"  :max="max" :value="min" class="form-control col-6" type="number">

                                </div>
                            <!-- ##/ number type  -->

                            <!-- Address type  -->
                                <div v-if="formInputType() === 'addressType'">

                                    <!-- marked as heading  -->
                                    <label for="address" v-if="inputHeading"><h6 class="d-inline">{{ inputHeading}}</h6> &nbsp;<span v-if="inputRequired" class="text-danger"><em>(required)*</em></span></label>
                                    <label v-else><h6 class="d-inline text-secondary">Label</h6> &nbsp;<span v-if="inputRequired" class="text-danger"><em>(required)*</em></span></label>

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

                                    <!-- marked as heading  -->
                                    <label v-if="inputHeading" class="d-block">{{ inputHeading}}</label>
                                    <label v-else class="d-block text-secondary">Label</label>

                                    <select class="custom-select col-4">
                                        <option style="color: " class="text-secondary" :value="inputPlaceholder" selected hidden disabled>{{inputPlaceholder || 'placeholder'}}</option>
                                        <option v-for="input in selectOptions" :key="selectOptions.indexOf(input)" :value="input.option">{{ input.option }}</option>
                                    </select>

                                </div>

                                <!-- ##/ select type  -->


                            <!-- make input dynamic  -->
                                <div v-if="inputDynamic" class="dynamic-btn">
                                    <button class="btn btn-info dynamic-btn__btn">&plus;<small :class="{'dynamic-btn__text': inputDynamicDescription}">{{ inputDynamicDescription }}</small></button>
                                </div>

                                <div v-if="groupDetails.groupDynamic" class="dynamic-btn">
                                    <button class="btn btn-info dynamic-btn__btn">&plus;<small :class="{'dynamic-btn__text': groupDetails.groupDynamicDescription}">{{ groupDetails.groupDynamicDescription }}</small></button>
                                </div>

                            </div>

                            <!-- ##-end of input  -->
                            <div v-if="formHtml && !inputType || inputType && showHiddenForm || inputType === 'payment'" id="submit-reset-btns" class="clearfix">
                                <div class="float-right">
                                    <button @click.prevent href="#" class="btn btn-light">Reset</button>
                                    <button @click.prevent href="#" class="btn btn-primary">{{ paymentAdded ? inputPbText : 'Submit'}}</button>
                                </div>
                            </div>


                        </div>

                         <div v-if="step === 2" class="d-flex justify-content-between">
                            <button @click.prevent="deleteSelected" class="btn btn-danger btn-sm my-1" :disabled="!previewSelected">Delete Selected</button>
                            <button @click.prevent="switchSelected" class="btn btn-info btn-sm my-1" :disabled="previewSelected !== 2">Switch Selected</button>
                            <button @click.prevent="createGroup" class="btn btn-primary btn-sm ml-2 my-1" :disabled="previewSelected < 2 || paymentSelected">Group Selected</button>
                        </div>

                    </div>

                <!-- ##/--============== form input ===============-- -->

                </div>
                    <!-- ##/modal-body  -->
                <div class="modal-footer">
                    <div v-if="step === 1" class="form-create__footer-btns">

                        <button type="button" class="btn btn-danger btns__icon" data-dismiss="modal"><span data-feather="x-circle"></span> Cancel</button>

                        <button @click.prevent="next" type="button" class="btn btn-primary" :disabled="!enableStartBtn">Next <span data-feather="arrow-right-circle"></span></button>

                    </div>
                    <div v-if="step === 2" class="form-create__footer-btns">
                        <div>
                            <button type="button" class="btn btn-danger btns__icon" data-dismiss="modal"><span data-feather="x-circle"></span> Cancel</button>
                        </div>

                        <div class="d-flex align-items-center justify-content-around">

                            <button @click.prevent="step = 1" class="btn btn-secondary mr-2 btns__icon"><span data-feather="arrow-left-circle"></span> Back</button>


                            <button @click.prevent="createEventForm" class="btn btn-primary" :disabled="!formHtml && !formInputs.length">Create Form <span data-feather="check-circle"></span></button>
                        </div>

                    </div>
                    <div v-if="step === 3" class="form-create__footer-btns">
                        <div>
                            <button type="button" class="btn btn-danger btns__icon" data-dismiss="modal"><span data-feather="x-circle"></span> Cancel</button>
                        </div>

                        <div class="d-flex align-items-center justify-content-around">

                            <button @click.prevent="backStep" class="btn btn-secondary mr-2 btns__icon"><span data-feather="arrow-left-circle"></span> Back</button>

                            <button @click.prevent="createInput(false, $event)" class="btn btn-primary" :disabled="!enableCreateInputBtn">{{ editMode ? 'Edit' : 'Create' }} Input <span data-feather="plus-circle"></span></button>

                        </div>


                    </div>
                </div>
                </div>
            </div>
        </div>


        <button @click.prevent="initEditForm" data-toggle="modal" data-target="#create-form" class="btn btn-primary btns__icon">{{ Object.keys(createdFormJson).length ? 'Edit Form' : 'Create Form' }} <span data-feather="file-plus" class="btns__icon--right"></span></button>

        <div v-if="createdFormHtml" class="form-create__disable-inputs form-create__disable-inputs--transparent mt-4">
            <div v-html="createdFormHtml" class="border shadow-sm mb-4 form-create__preview"></div>
        </div>

    </div><!-- ./form-create  -->



</template>

<script>

    import { muid } from '../../mixins/muid';
    const feather = require('feather-icons');


export default {

    mixins: [ 'muid' ],

    data() {
        return {
            addQuantity: false,
            createdFormHtml: "",
            createdFormJson: {},
            checkboxCount: 1,
            checkboxInputs: [ {
                label: "",
                description: ""
            }, ],
            setCheckboxDelay: false,
            selectCount: 1,
            selectOptions: [ {
                option: ""
            } ],
            groupDetails: {
                id: muid(),
                heading: "",
                description: "",
                groupDynamic: false,
                groupDynamicDescription: "",
            },
            groupInputsHtml: "",
            formHtml: "",
            showHiddenForm: false,
            showFormHtml: "",
            showFormInputs: [],
            formInputs: [],
            formHeading: null,
            formEmail: null,
            inputHeading: "",
            inputPlaceholder: "",
            inputType: null,
            inputLabel: "",
            inputDescription: null,
            inputDynamic: false,
            inputDynamicDescription: "",
            inputRequired: false,
            inputInfoMode: false,
            inputPbText: "Purchase",
            quanityInputLabel: 'Quantity',
            inputTotal: "0.00",
            showPrice: "0.00",
            infoHtml: "",
            min: 0,
            max: 10,
            paymentAdded: false,
            previewSelected: 0,
            paymentSelected: false,
            step: 1,
            formHidden: false,
            editMode: false,
            editId: null,
            quantityNum: 0,
        }
    },



    computed: {

    // removes disabled from start button when heading and email is filled out
        enableStartBtn() {
            return this.formHeading && this.formEmail ? true : false;
        },



    // removes disable from create input btn
        enableCreateInputBtn() {

            if(this.showHiddenForm) return false;


            if(this.formInputType() === 'paymentType') {
                if(this.inputTotal !== "0.00") return true;
            }



            if(this.formInputType() === 'groupType') return true;




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
                if(this.formInputType() !== 'paymentType') {
                     return this.inputLabel || this.inputHeading ? true : false;
                }
            }

        },

        dynamicControl() {
            if(
                this.formInputType() === 'textType' ||
                this.formInputType() === 'groupType'
            ) {
                return true;
            } else {
                return false;
            }
        },


    },




    methods: {

        //============ EVENTS ================================================/

        addCheckboxLabelDescriptionFields(e) {


            $(e.target).prop('disabled', true);


            // Add input object
                if(this.checkboxInputs.length < this.checkboxCount ) {

                    const diff = parseInt(this.checkboxCount) - this.checkboxInputs.length;

                    for(let i = 1; i <= diff; i++) {

                         const inputs = {
                            label: "",
                            description: ""
                        }


                        this.checkboxInputs.push(inputs);
                    }

                }


            // remove input object
                if(this.checkboxInputs.length > this.checkboxCount) {

                    const diff = this.checkboxInputs.length - parseInt(this.checkboxCount);

                    for(let i = 1; i <= diff; i++) {
                        this.checkboxInputs.pop();
                    }

                }

            // Set delay to prevent button mashing
                setTimeout(() => {
                    $(e.target).prop("disabled", false);
                }, 300);


        },



    // adds dynamic btn event after the button has been created
        addDynamicBtnEvent() {
            const dyBtns = $(".dynamic-btn");

            $(dyBtns).each( (i, btn) => {

                $(btn).on('click', this.dynamicAddDup);

            } );
        },


    // enable quantity input
        addQuantityInput() {
            this.addQuantity = this.addQuantity ? false : true;
            this.showPrice = this.inputTotal;
        },

    // add quantity input html event
        addHtmlQuantityEvent() {

            const quantityInput = $('#html-quantity-input');

            $(quantityInput).on('change', this.calPrice);

        },


// add options for select element
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


    // Back Event
        backStep() {
            this.step--;

            this.reset();

            this.checkPaymentExists();

        },



    // calculate the total price
    calPrice(e) {



            const priceType = $(e.target).attr('data-price-type');


        // user input to calculate price
            if(priceType === 'user-input') {
                $('#addQuantity').val("1");

                let total = $(e.target).val();

                total = this.calPriceConvertTotal(total);

                // change user value to format value
                    $(e.target).val(total);

                // insert value into input total
                    this.inputTotal = total;
                    this.showPrice = total;

            }

        // quantity input to calculate price
            if(priceType === 'quantity-input' || priceType === 'html-quantity-input') {

                const quantityVal = $(e.target).val();

                let    price =  '';

                    if(priceType !== 'html-quantity-input'){

                        price = this.inputTotal * quantityVal;

                        this.showPrice = this.calPriceConvertTotal(price.toString());

                    } else {

                        const currentTotal = parseFloat($(e.target).attr('data-total'));

                        price = currentTotal * quantityVal;
                        price = this.calPriceConvertTotal(price.toString());

                    // set values in html
                        $('#input-total').text(price);

                    }


            }


        },

        createEventForm() {

            const formProperties = {
                info: {
                    heading: this.formHeading,
                    email: this.formEmail
                },
                inputs: this.formInputs
            }


            this.createFormHtml(false, true);

            this.createdFormHtml = this.formHtml;
            this.createdFormJson =  formProperties;
            this.$emit('eventFormJson', formProperties);

            $('#create-form').modal('hide');

            this.reset(true);

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


        //add group details
            if(selectedInputs[0].id === undefined)
                selectedInputs.unshift(this.groupDetails);

            this.formInputs.splice(insertPosition, 0, selectedInputs);

            this.createFormHtml();

            this.previewInputsSelected(true);

        },


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

            // remove  payment button.
                removeIds.forEach( id => {
                    if(this.formInputs[id].type === 'payment') {
                        this.paymentAdded = false;
                    }
                } );



               this.formInputs = this.formInputs.filter( (input, i) => {
                    return removeIds.indexOf(i) == -1;
                } );

                this.createFormHtml();
                this.previewInputsSelected(true);


            }

        },



    // add duplicate of input
         dynamicAddDup(e) {
            e.preventDefault();

            const btn = $(e.target).closest(".dynamic-btn"),
                  id = parseInt($(btn).attr("data-id")),
                  input = this.formInputs[id],
                  uid = muid(),
                  removeBtn = `<div class="d-flex justify-content-end"><button class="btn btn-danger btn-sm remove-btn" data-id="${uid}">Remove</button></div>`;


            let   inputHtml = `<div data-remove="${uid}">`;


                if(Array.isArray(input)) {

                    input.forEach( (item, i) => {

                        if(i) inputHtml += this.inputCreate(item, true);

                        if(input.length === (i + 1)) inputHtml += removeBtn;

                    } );

                } else {

                    inputHtml += this.inputCreate(input, true);
                    inputHtml += removeBtn;

                }


                inputHtml += "</div>";


                $(btn).before(inputHtml);

                setTimeout(() => {
                    this.removeDupEvent();
                }, 500);

        },



        editInput() {

            const previewSelects = $('.preview-select-input');

            let id = "",
                group = false;



            $(previewSelects).each( ( i, input ) => {

                if($(input).prop('checked')) {

                    id = parseInt($(input).attr('id'));

                    if($(input).attr('data-type') === 'group') group = true;

                    return;

                }

            } );

            const input = this.formInputs[id];


            this.editMode = true;
            this.editId = id;

            if( group ) {

                const groupDetails = input[0];

                this.groupDetails.id = groupDetails.id;
                this.groupDetails.heading = groupDetails.heading;
                this.groupDetails.description = groupDetails.description;
                this.groupDetails.groupDynamic = groupDetails.groupDynamic;
                this.groupDetails.groupDynamicDescription = groupDetails.groupDynamicDescription;

                this.inputType = 'group';

                input.forEach( (groupInput, i) => {
                    if(i)
                    this.groupInputsHtml += this.inputCreate(groupInput);
                } );


            } else {
                this.checkboxCount = input.checkBoxes.length;
                this.checkboxInputs = input.checkBoxes;
                this.selectCount = input.selectOptions.length;
                this.selectOptions = input.selectOptions;
                this.inputHeading = input.heading;
                this.inputPlaceholder = input.placeholder;
                this.inputTotal = input.inputTotal;
                this.addQuantity = input.addQuantity;
                this.quanityInputLabel = input.quanityInputLabel;
                this.showPrice = input.inputTotal;
                this.inputType = input.type;
                this.inputLabel = input.label;
                this.inputDynamic = input.dynamic;
                this.inputDescription = input.description;
                this.inputDynamicDescription = input.dynamicDescription;
                this.inputRequired = input.required;
                this.min = input.min;
                this.max = input.max;
            }

            this.formHidden = true;
            this.step = 3;

        },


    // event for when input is selected to enable buttons
        formInputSelectedEvent() {

            const previewInputs = $(".preview-select-input");

            $(previewInputs).each( ( i, input ) => {

                $(input).on('click', e =>  {
                    this.previewInputsSelected(false, e);
                });

            } );

        },


        initEditForm() {
            if( !Object.keys(this.createdFormJson).length ) return;

            this.formHeading = this.createdFormJson.info.heading;
            this.formEmail = this.createdFormJson.info.email;
            this.formInputs = this.createdFormJson.inputs;

            this.createFormHtml();

        },




    // display info text for each button element
        inputInfo() {

            this.inputInfoMode = true;

            const textInfo = `<h6>Input Required</h6><p>You may toggle this option to make this input required. A required input won't allow the form to be submitted until this input is filled.</p><h6>Enter Label</h6><p>This option is used to add a label to your input. This option is REQUIRED for seo, assistive technologies, and general functionality of your form. The label will be used as the input name that you will get back in the email when a user has submitted the form.</p><h6>Enter Description</h6><p>This option allows you to give more details about what information you want from the user. This option is optional!</p><h6>Enter Placeholder</h6><p>This option is used for give examples of how you want the user to fill in the input. This option is optional!</p><h6>Make Dynamic</h6><p>This option allows you to give users the ability to add/(duplicate) this input. Example of a good use for this is family registrations where families have different amounts of kids. You can create an input to capture a child's name and make it dynamic so the parent can add their other children as well. Button label is optional!</p>`;

            let html = "";


            switch (this.inputType) {

                case 'text':
                    html += `<h6>Input Details</h6><p>The <strong>Single Line</strong> input is used to capture just one line of information from a user like their name!</p>${textInfo}`;
                    break;

                case 'email':
                    html += `<h6>Input Details</h6><p>The <strong>Email</strong> input is used to capture the email of a user. While this input looks identical to the single line input, the email input will validate if the information enter into the input is indeed an email!</p>${textInfo}`;
                    break;

                case 'textarea':

                    html += `<h6>Input Details</h6><p>The <strong>Paragraph</strong> input allows the user to write multple lines of text. This is quite useful for messages or long details.</p>${textInfo}`;

                    break;

                case 'tel':
                    html += `<h6>Input Details</h6><p>The <strong>Phone</strong> input is used to capture a users phone number. While this input looks identical to the single line input, the phone input will validate if the information entered into the input is indeed a phone number!</p>${textInfo}`;
                    break;

                case 'number':

                    html += `<h6>Input Details</h6><p>The <strong>Number</strong> input allows a user to set a specific number.</p><h6>Enter Label</h6><p>This option is used to add a label to your input. This option is REQUIRED for seo, assistive technologies, and general functionality of your form. The label will be used as the input name that you will get back in the email when a user has submitted the form.</p><h6>Enter Description</h6><p>This option allows you to give more details about what information you want from the user. This option is optional!</p><h6>Enter Minimum Value</h6><p>This options allows you to set the MINIMUM value a user can enter.</p><h6>Enter Maximum Value</h6><p>This option allows you to set the MAXIMUM value a user can enter.</p>`;


                    break;

                case 'checkbox':

                    html += `<h6>Input Details</h6><p>The <strong>Checkbox</strong> input allows the user to select MULTIPLE options via checkboxes. If you only want to allow the user to select one option use Radio or Select inputs.</p><h6>Enter Heading</h6><p>This option is used to add a label to your input. This option is REQUIRED for seo, assistive technologies, and general functionality of your form. The heading will be used as the input name that you will get back in the email when a user has submitted the form.</p><h6>Enter how many Checkboxes you need</h6><p>This option allows you to increase or decrease the amount of checkboxes for this input. Each checkbox has a description and label field. Label field is REQUIRED for each checkbox.</p><h6>Enter Description</h6><p>This option allows you to write a description for this particular checkbox. This option is optional!</p><h6>Enter Label</h6><p>This option allows you to write a label for this particular checkbox. This option is optional!</p>`;


                    break;


                    case 'radio':

                        html += `<h6>Input Details</h6><p>The <strong>Radio</strong> input allows the user to select a SINGLE option via checkboxes. If you want a user to be able to select multiple options use checkbox.</p><h6>Enter Heading</h6><p>This option is used to add a label to your input. This option is REQUIRED for seo, assistive technologies, and general functionality of your form. The heading will be used as the input name that you will get back in the email when a user has submitted the form.</p><h6>Enter how many Radio's you need</h6><p>This option allows you to increase or decrease the amount of radio's for this input. Each radio has a description and label field. Label field is REQUIRED for each radio.</p><h6>Enter Description</h6><p>This option allows you to write a description for this particular radio. This option is optional!</p><h6>Enter Label</h6><p>This option allows you to write a label for this particular radio. This option is optional!</p>`;


                        break;


                    case 'select':

                        html += `<h6>Input Details</h6><p>The <strong>Select</strong> input allows the user to select a SINGLE option. If you want a user to be able to select multiple options use checkbox.</p><h6>Enter Heading</h6><p>This option is used to add a label to your input. This option is REQUIRED for seo, assistive technologies, and general functionality of your form. The heading will be used as the input name that you will get back in the email when a user has submitted the form.</p><h6>Enter Placeholder</h6><p>You may use this option to give direction to the user on what to do. example: "Choose..." or "Select One..." This option is optional!</p><h6>Enter how many options you need</h6><p>This option allows you to increase or decrease the amount of options for the select input.</p><h6>Enter Option</h6><p>Enter the option that you would like to be availble to select.</p>`;


                        break;

                    case 'address':

                        html += `<h6>Input Details</h6><p>The <strong>Address</strong> input allows the user to enter their address.</p><h6>Input Required</h6><p>You may toggle this option to make this input required. A required input won't allow the form to be submitted until this input is filled.</p><h6>Enter Label</h6><p>This option is used to add a label to your input. This option is REQUIRED for seo, assistive technologies, and general functionality of your form. The label will be used as the input name that you will get back in the email when a user has submitted the form.</p><h6>Enter Description</h6><p>This option allows you to give more details about what information you want from the user. This option is optional!</p>`;



                        break;


                default:
                    break;
            }


            this.infoHtml = html;

        },


// next step
        next() {
            this.step++;
        },


        removeDupEvent() {

            const removeBtns = $(".remove-btn");


            $(removeBtns).each( ( i, btn ) => {
                $(btn).on('click', this.removeDup);
            } );


        },

        // Reset data when modal is dismissed
        resetDataModalDismiss() {
            $('#create-form').on('hidden.bs.modal', () => {
                this.reset(true);
            });
        },

         // event select all
        selectAll(e) {
             const previewInputs = $(".preview-select-input");


            $(previewInputs).each( (i, input) => {
                $(input).prop('checked', $(e.target).prop('checked'));
            } );


            this.previewInputsSelected();

        },

        // Enter selected input type
        selectedInput(e) {

            this.inputType = $(e.target).attr('data-type');

            this.formHidden = true;

            this.next();

            if(this.inputType === 'payment') this.paymentAdded = true;

        },


        // show html form when creating input
        showForm(e) {



            if($(e.target).prop('checked')) {

                this.createInput(true);

                this.showHiddenForm = true;

            } else {

                this.showHiddenForm = false;

                this.showFormHtml = "";
                this.showFormInputs = [];

            }

        },


        switchSelected() {


            const previewSelects = $('.preview-select-input'),
                  formInputs = [...this.formInputs];

            let ids = [];

            // get the ids
                $(previewSelects).each( ( i, selected ) => {

                    if( $(selected).prop('checked') ) {

                        let id = parseInt($(selected).attr('id'));

                        ids.push( id );

                    }

                } );

                const inputOne = formInputs[ids[0]],
                      inputTwo = formInputs[ids[1]];


                      formInputs[ids[0]] = inputTwo;
                      formInputs[ids[1]] = inputOne;

                    this.formInputs = formInputs;

                    this.createFormHtml();
                    this.reset();

        },



//============ /## EVENTS ================================================/

//============ FUNCTIONS ================================================/




    // convert number into money format.
        calPriceConvertTotal(total) {

            // add decimal if not present
                if(!total.includes('.')) total += '.00';


            // corrects if decimal goes into thousandths or more ex. 12.123
                if(total.match(/(?<=\.\d{2})\d+$/)) {
                    const regExMatch = total.match(/(?<=\.\d{2})\d+$/)[0];

                    total = total.replace(regExMatch, "");
                }


            // adds zero if missing hundredths
                if(total.match(/(?<=\.)\d{1}$/)) total += '0';


            return total;

        },



    // check
        checkPaymentExists() {

            let payment = false;

            if(this.inputType === 'payment') {
                    this.paymentAdded = true;
                    return;
                }


           this.formInputs.forEach( input => {

                if(input.type === 'payment') {
                    this.paymentAdded = true;
                    payment = true;
                }

            } );


            if(!payment) this.paymentAdded = false;


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



// Create the main html form!
        createFormHtml(showForm = false, createForm = false) {

            const formInputsArray = !showForm ? this.formInputs : this.showFormInputs;


            let html = '',
                paymentHtml = '';


            html += createForm ? `<h4>${this.formHeading}</h4>` : '';


            formInputsArray.forEach( (input, i) => {

                const showInputName = Array.isArray(input) ? 'group' : this.showInputType(input);

            // adds the select to the form
                  let  selectBoxHtml = !createForm ? `<div class="form-check float-right form-create__preview-select preview-select">
                                <label class="form-check-label text-secondary form-create__pointer" for="${i}">${showInputName}</label>
                                <input id="${i}" class="form-check-input form-create__preview-select-input preview-select-input form-create__pointer" data-type="${showInputName}" type="checkbox"  ${showForm ? 'disabled' : ''}>
                            </div>` : '';




                if(input.type !== 'payment') {

                // form group start div
                    html += `${selectBoxHtml}<div class="form-group">`;


                        if(Array.isArray(input)) {

                            input.type = 'group'; // set input type to group

                            html += this.inputCreate(input);

                        } else {

                            html += this.inputCreate(input);

                        }

                    html += '</div>';

                } else {

                    paymentHtml = `${selectBoxHtml}<div class="form-group">${this.inputCreate(input)}</div>`;
                }

            } );


            if(paymentHtml) { html += paymentHtml; }

            if(createForm) {
                html += `<div class="clearfix">
                            <div class="float-right">
                                <button href="#" class="btn btn-light">Reset</button>
                                <button href="#" class="btn btn-primary">${ paymentHtml ? this.inputPbText : 'Submit' }</button>
                            </div>
                        </div>`;
            }

            !showForm ?
                this.formHtml = html :
                this.showFormHtml = html;

        },



        createGroupInputs(groupInputs) {
           let html = "";

            groupInputs.forEach( ( input, i ) => {

                if(i) {

                    input.dynamic = false;
                    input.dynamicDescription = "";

                    html += this.inputCreate(input);
                };

            } );

            return html;

        },

// Creates or rather adds the input properties into an object and pushes the data into the form inputs array.
        createInput(showForm = false) {

            let input = {};

            if(this.inputType === 'group') {

                    input = this.groupDetails;

            } else {
                input.addQuantity = this.addQuantity;
                input.quanityInputLabel = this.quanityInputLabel;
                input.inputTotal = this.inputTotal;
                input.inputPbText = this.inputPbText;
                input.checkBoxes = this.checkboxInputs;
                input.label = this.inputLabel;
                input.heading = this.inputHeading;
                input.placeholder = this.inputPlaceholder;
                input.type = this.inputType;
                input.dynamic = this.inputDynamic;
                input.dynamicDescription = this.inputDynamicDescription;
                input.dupCount = 0;
                input.description = this.inputDescription;
                input.required = this.inputRequired;
                input.max = this.max;
                input.min = this.min;
                input.selectOptions = this.selectOptions;
                input.name = this.getInputName(true);
            }



            if(showForm) {

                this.showFormInputs = [...this.formInputs];


            // if edit mode add input in correct position else just add to the end
               this.editMode ?
                    this.showFormInputs.splice(this.editId, 1, input) :
                    this.showFormInputs.push(input);



                this.createFormHtml(true);

                return;

            }


            if (this.editMode) {

                this.inputType === 'group' ?
                    this.formInputs[this.editId][0] = input :
                    this.formInputs[this.editId] = input;

            } else {

                this.formInputs.push(input);

            }

            this.reset();

            this.createFormHtml();

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
                inputHtml = `<input id="${input.name}" type="${input.type}" name="${input.name}" class="form-control mb-4" placeholder="${input.placeholder}" ${required}>`;
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

            if(input.type === 'payment') {

                // dont forget to fix event listener for add quantity button
                const addQuantity = input.addQuantity ? `<div class="mb-2">
                                    <label for="addQuantity">${input.quanityInputLabel}</label>
                                    <input id="html-quantity-input" data-price-type="html-quantity-input" data-total="${input.inputTotal}" name="addQuantity" class="form-control col-6" type="number" min="1" max="50" value="1" id="addQuantity">
                                </div>` : "";



                inputHtml = `<div class="my-3">
                                    <div class="form-check">
                                        <input id="credit" name="paymentMethod" value="credit" type="radio" class="form-check-input" checked required>
                                        <label class="form-check-label" for="credit">Credit card</label>
                                    </div>
                                    <div class="form-check">
                                        <input id="debit" name="paymentMethod" type="radio" class="form-check-input" value="debit" required>
                                        <label class="form-check-label" for="debit">Debit card</label>
                                    </div>
                                </div>


                                ${input.required ? '<p class="text-danger"><em> All payment fields are (required)*</em></p>' : ''}


                                <div class="row gy-3">

                                    <div class="col-md-6">
                                        <label for="cc-name" class="form-label">Name on card</label>

                                        <input type="text" class="form-control" id="cc-name" placeholder="" required>

                                        <div class="invalid-feedback">
                                            Name on card is required
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="cc-number" class="form-label">Credit card number</label>
                                        <input type="text" class="form-control" id="cc-number" placeholder="" required>
                                        <div class="invalid-feedback">
                                            Credit card number is required
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="cc-expiration" class="form-label">Expiration</label>
                                        <input type="text" class="form-control" id="cc-expiration" placeholder="" required>
                                        <div class="invalid-feedback">
                                            Expiration date required
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="cc-cvv" class="form-label">CVV</label>
                                        <input type="text" class="form-control" id="cc-cvv" placeholder="" required>
                                        <div class="invalid-feedback">
                                            Security code required
                                        </div>
                                    </div>
                                </div>

                                ${addQuantity}

                                <div class="clearfix mb-2">
                                    <div class="float-right"><p><strong>Total: </strong><span id="input-total">${ input.inputTotal }</span></p></div>
                                </div>`;
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

                if(input.dupCount) name += `_${input.dupCount}`;

                return name;

        },





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

            // return group type
                if(
                    inputType === 'group'
                ) {
                    return 'groupType';
                }

            // return payment type
                if(
                    inputType === 'payment'
                ) {
                    return 'paymentType';
                }

        },

        // This creates the inputs with labels and descriptions
        inputCreate(input, dup = false) {

            if(dup) input.dupCount += 1;

            let html = "";

                const inputType = this.formInputType(input.type),

                    required = input.required ? '&nbsp;<span class="text-danger"><em>(required)*</em></span>' : '',

                    descriptionHtml = input.description ? `<p class="text-secondary"><em>${input.description}</em></p>` : '',

                    dynamicDescription = input.dynamicDescription ? `<small class="dynamic-btn__text">${ input.dynamicDescription }</small>` : "",

                    dynamicBtnHtml = input.dynamic && !dup ? `<div data-id="${this.formInputs.indexOf(input)}" class="dynamic-btn">
                                        <button class="btn btn-info dynamic-btn__btn">&plus;${dynamicDescription}</button>
                                    </div>` : "";


                    if(inputType === 'textType') {

                        html += `<label for="${input.name}">${input.label} ${required}</label>
                                ${descriptionHtml}
                                ${this.createInputHtml(input)}
                                ${dynamicBtnHtml}`;
                    }


                    if(inputType === 'checkboxType') {

                        html += `<label>${input.heading}</label>
                                 ${this.createCheckboxInputsHtml(input)}`;

                    }


                    if(inputType === 'numberType') {

                        html += `<label for="${input.name}">${input.label}</label>
                                    <p class="text-secondary"><em>${descriptionHtml}</em></p>
                                    ${this.createInputHtml(input)}`;

                    }


                    if(inputType === 'addressType') {

                        html += `<label>${input.heading} ${required}</label>
                                    <p class="text-secondary"><em>${descriptionHtml}</em></p>
                                    ${this.createInputHtml(input)}`;

                    }


                    if(inputType === 'selectType') {
                            html += `<label>${input.heading}</label>
                                ${this.createInputHtml(input)}`;

                    }



                    if(inputType === 'groupType') {


                        const groupDetails = input[0],

                             groupHeading = groupDetails.heading && !dup ? `<label>${groupDetails.heading}</label>` : "",

                              groupDescription = groupDetails.description && !dup ? `<p class="text-secondary"><em>${groupDetails.description}</em></p>` : '',

                              groupDynamicDescription = groupDetails.groupDynamicDescription ? `<small class="dynamic-btn__text">${ groupDetails.groupDynamicDescription }</small>` : "",

                              groupDynamic = groupDetails.groupDynamic && !dup ? `<div data-id="${this.formInputs.indexOf(input)}" class="dynamic-btn">
                                        <button class="btn btn-info dynamic-btn__btn">&plus;${groupDynamicDescription}</button>
                                    </div>` : "";


                        html += `${groupHeading}
                                 ${groupDescription}
                                 ${this.createGroupInputs(input)}
                                 ${groupDynamic}`;


                    }



                    if(inputType === 'paymentType') {

                            html += `<label>${input.label}</label>
                                    ${descriptionHtml}
                                    ${this.createInputHtml(input)}`;

                    }


                    return html;

        },


// increases count to access delete/group/selectall btns
        previewInputsSelected(reset = false, e = '') {

            if(e) {

                const selected = e.target;


                if(selected.getAttribute('data-type') === 'payment') {

                   this.paymentSelected = selected.checked ? true : false;

                }

            }

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


// remove dup element
        removeDup(e) {
            e.preventDefault();

            const id = $(e.target).attr('data-id');

            $(`[data-remove="${id}"]`).remove();

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
            this.groupDetails = {
                id: muid(),
                heading: "",
                description: "",
                groupDynamic: false,
                groupDynamicDescription: "",
            };
            this.groupInputsHtml = "";
            this.inputHeading = "";
            this.inputPlaceholder = "";
            this.inputType = null;
            this.inputLabel = "";
            this.inputTotal = "0.00";
            this.showPrice = "0.00";
            this.inputPbText = "Purchase";
            this.quanityInputLabel = 'Quantity';
            this.addQuantity = false;
            this.inputDynamic = false;
            this.inputDescription = null;
            this.inputDynamicDescription = "";
            this.inputInfoMode = false;
            this.inputRequired = false;
            this.min = 0;
            this.max = 10;
            this.formHidden = false;
            this.editMode = false;
            this.editId = null;

            this.showHiddenForm = false;
            this.showFormHtml = "";
            this.showFormInputs = [];

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

            if(inputName === 'group') name = 'group';

            if(inputName === 'payment') name = 'payment';


            if(capitalize) name = name.charAt(0).toUpperCase() + name.slice(1);;


            return name;

        },


//============ /## FUNCTIONS ================================================/


    }, // ##-METHODS ---/





    updated() {
        this.formInputSelectedEvent();
        this.addDynamicBtnEvent();
        this.addHtmlQuantityEvent();
        feather.replace();
    }, // ##-UPDATED




    mounted() {
        this.resetDataModalDismiss(); // add the reset method to the cancel modal event
    }


}


</script>

<style>

</style>
