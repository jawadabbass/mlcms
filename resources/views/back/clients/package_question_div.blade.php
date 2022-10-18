@if (!$package_questions == null)
    <div class="col-lg-12">
        <div class="row clearfix">
            <div class="col-lg-12 form-group">

                <div class="contact-servicewrap">

                    <h3 style="text-align: center">
                        Package Pre Qualified Questions
                    </h3>

                    @foreach ($package_questions as $p_question)
                        <div class="contact_box">

                            <div class="questText">{{ $p_question->question }}</div>

                            <div class="radio_box">

                                @if ($p_question->pattern == 'check')
                                    <?php $i = 1; ?>
                                    <div class="row">
                                        @foreach (json_decode($p_question->value) as $val)
                                            <div class="col-md-4">
                                                <div class="checkbox">
                                                    <input
                                                        type="checkbox"name="answer[{{ $p_question->id }}][{{ $val }}]"
                                                        value="<?php $val; ?>"
                                                        id="3dgraphic<?php echo $i; ?><?php echo $p_question->id; ?>"
                                                        <?php if ($i == 1) {
                                                            echo "checked='checked'";
                                                        } ?>>
                                                    <label
                                                        for="3dgraphic<?php echo $i; ?><?php echo $p_question->id; ?>"></label>
                                                    {{ $val }}
                                                </div>
                                            </div>
                                            <?php $i++; ?>
                                        @endforeach
                                    </div>
                                @endif

                                @if ($p_question->pattern == 'radio')
                                    <?php $i = 1; ?>

                                    @foreach (json_decode($p_question->value) as $val)
                                        <div id="ans[]" class="radiobtn">

                                            <input type="radio" value="<?php echo $val; ?>"
                                                name="answer[{{ $p_question->id }}]" <?php if ($i == 1) {
                                                    echo "checked='checked'";
                                                    $i++;
                                                } ?>>

                                            <i class="checkmark"></i> {{ $val }}

                                        </div>
                                    @endforeach
                                @endif

                                @if ($p_question->pattern == 'input')
                                    <div class="form-group">

                                        <input type="text" name="answer[{{ $p_question->id }}]"
                                            class="form-control">

                                    </div>
                                @endif

                            </div>

                        </div>
                    @endforeach

                </div>
            </div>

        </div>
    </div>
@endif
