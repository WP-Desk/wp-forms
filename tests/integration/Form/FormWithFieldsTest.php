<?php

namespace integration\Form;

use WPDesk\Forms\Field\InputNumberField;
use WPDesk\Forms\Field\InputTextField;
use WPDesk\Forms\Field\SelectField;
use WPDesk\Forms\Form\FormWithFields;
use PHPUnit\Framework\TestCase;

class FormWithFieldsTest extends TestCase {

	/** @var FormWithFields */
	private $form;

	protected function setUp() {
		$this->form = new FormWithFields([]);
	}

	public function test_should_return_fields_sorted_by_priority() {
		$this->form->add_fields(
			[
				( new InputTextField() )
				->set_label('fourth'),
				( new SelectField() )
				->set_label('second')
				->set_priority(5),
				( new SelectField() )
				->set_label('third')
				->set_priority(7),
				( new InputNumberField() )
				->set_label('first')
				->set_priority(1)
			]
		);

		$expected = [
			( new InputNumberField() )
			->set_label('first')
			->set_priority(1),
			( new SelectField() )
			->set_label('second')
			->set_priority(5),
			( new SelectField() )
			->set_label('third')
			->set_priority(7),
			( new InputTextField() )
			->set_label('fourth')
		];

		self::assertEquals($expected, $this->form->get_fields());
	}

	public function test_should_return_fields_by_adding_order_if_no_priority_set() {
		$this->form->add_fields(
			[
				( new InputTextField() )
					->set_label('first'),
				( new SelectField() )
					->set_label('second'),
				( new InputNumberField() )
					->set_label('third'),
			]
		);

		$expected = [
			( new InputTextField() )
				->set_label('first'),
			( new SelectField() )
				->set_label('second'),
			( new InputNumberField() )
				->set_label('third'),
		];

		self::assertEquals($expected, $this->form->get_fields());
	}
}
