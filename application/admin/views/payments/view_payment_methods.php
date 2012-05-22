			<div class="container">
				<div class="conthead">
				<?php $this->load->view('payments/payments_submenu')?>
				</div>
				<div class="contentbox">
					<div class="center_contentbox">
						
						<h2><?php echo lang('Your Payment Methods')?></h2>
						<?php if( ! empty($payment_methods)):?>
							<?php foreach($payment_methods as $payment): ?>
							<hr class="line_break_2">
							<div class="clear"></div>
							<h3><?php echo $payment->name ?></h3>
							<div class="inputboxes">
									<label for="name"><?php echo lang('Name')?>: </label>
									<?php echo form_input('name', set_value('name', $payment->name), 'id="name" class="inputbox payment" readonly="readonly" tabindex="1" type="text"')?>
							</div>
							<div class="inputboxes">
									<label for="minimum_amount"><?php echo lang('Minimum amount')?>: </label>
									<?php echo form_input('minimum_amount', set_value('minimum_amount', $payment->minim_amount), 'id="minimum_amount" class="inputbox payment" readonly="readonly" tabindex="1" type="text"')?>
							</div>
							<?php $extra_fields = unserialize($payment->fields);
								  foreach($extra_fields as $key => $field): ?>
							<div class="inputboxes">
									<label for="extrafield_<?php echo ($key+1) ?>"><?php echo lang('Extra Field') . ' ' . ($key+1) ?>: </label>
									<?php echo form_input('extrafield_' . ($key+1) , set_value('extrafield_' . ($key+1), $field), 'id="extrafield_' . ($key+1) . '" class="inputbox payment" readonly="readonly" tabindex="1" type="text"')?>
							</div>
							<?php endforeach ?>
							<div class="inputboxes">
									<label for="status"><?php echo lang('Status')?>: </label>
									<?php echo form_input('status', set_value('status', $payment->status), 'id="status" class="inputbox payment" readonly="readonly" tabindex="1" type="text"')?>
							</div>
							<br/>
							<a href="<?php echo site_url('payment-methods/edit/' . $payment->id )?>"><?php echo lang('Edit Payment Method') ?></a><span class="leftspace"></span>
							<a href="<?php echo site_url('payment-methods/delete/' . $payment->id )?>" onclick="javascript:return confirm('<?php echo lang('Are you sure you want to delete this payment method?')?>');"><?php echo lang('Delete Payment Method') ?></a>
							<br/>
							<br/>
							<?php endforeach ?>		
						<?php else: ?>
							<h3><?php echo lang('You have no payment methods set')?></h3>
						<?php endif ?>	
					</div>
				</div>
			</div>
