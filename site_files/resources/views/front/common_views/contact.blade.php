     <div class="contact-wraper">
         <div class="container">
             <div class="row">
                 <!--Have Any Question? Let Us Know! -->
                 <div class="col-md-8">
                     <div class="form-wraper">
                         <?php if($is_Have_Any_Question){?>
                         <div class="form-heading"><?php echo $Have_Any_Question[0]['heading']; ?></div>
                         <p> <?php echo $Have_Any_Question[0]['content']; ?></p>
                         <?php }?>

                         <form class="row" action="<?php echo base_url(); ?>home/send" method="post">
                             <?php if($this->session->flashdata('send_action') == TRUE){
                                ?>
                             <div class="col-md-12">
                                 <h2 style="color: red; padding-bottom: 10px;">Your Message is Sent Successfully.</h2>
                             </div>
                             <?php
                            }
                            ?>

                             <div class="col-md-6">
                                 <div class="form-group">
                                     <input type="text" name="first_name" value="<?php echo set_value('first_name'); ?>"
                                         class="form-control contact-form" id="exampleInputEmail1ss"
                                         placeholder="Full Name">
                                     <?php echo form_error('first_name'); ?>
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group">
                                     <input type="text" name="last_name" value="<?php echo set_value('last_name'); ?>"
                                         class="form-control contact-form" id="exampleInputEmail1"
                                         placeholder="Last Name">
                                     <?php echo form_error('last_name'); ?>
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group">
                                     <input type="email" name="email" value="<?php echo set_value('email'); ?>"
                                         class="form-control contact-form" id="exampleInputEmail1" placeholder="Email">
                                     <?php echo form_error('email'); ?>
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group">
                                     <input type="text" name="phone_number" value="<?php echo set_value('phone_number'); ?>"
                                         class="form-control contact-form" id="exampleInputEmail1" placeholder="Phone">
                                     <?php echo form_error('phone_number'); ?>
                                 </div>
                             </div>
                             <div class="col-md-12">
                                 <div class="form-group">
                                     <textarea name="message" class="form-control contact-textarea" rows="5" placeholder="Your Message"><?php echo set_value('message'); ?></textarea>
                                     <?php echo form_error('message'); ?>
                                 </div>
                             </div>
                             <div class="col-md-12">
                                 <div class="form-group">
                                     <p>Please type the following characters in the box below:<br><?php echo $capImage; ?>
                                     </p>
                                     <input type="text" name="cpt_code" style="width: 200px;"
                                         value="<?php echo set_value('cpt_code'); ?>" class="form-control contact-form"
                                         id="exampleInputEmail1" placeholder="Please type character">
                                     <?php echo form_error('cpt_code'); ?>
                                     <?php echo form_error('validate_code'); ?>

                                 </div>
                             </div>
                             <div class="contact-butn">
                                 <input type="submit" value="Submit" class="contact-button">
                             </div>
                         </form>
                         <?php if (validation_errors() != false) { ?>
                         <script type="text/javascript">
                             function explode() {

                                 document.getElementById("exampleInputEmail1ss").focus();

                             }
                             setTimeout(explode, 1000);
                         </script>
                         <?php } ?>
                     </div>
                 </div>
                 <!--Have Any Question? Let Us Know! -->
                 <!--Our Location-->
                 <div class="col-md-4">
                     <div class="location-wraper">
                         <div class="location-heading">Our Location </div>
                         <?php $adminInfo = settingInfo(); ?>
                         <div class="adress"> <?php echo $adminInfo['address']; ?></div>
                         <div class="email"> <?php echo $adminInfo['email']; ?> </div>
                         <div class="phone"><?php echo $adminInfo['telephone']; ?> </div>
                     </div>
                 </div>
                 <!-- Our Location-->
             </div>
         </div>
     </div>
