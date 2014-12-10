<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Qiwi extends Controller_Layout {

	/**
	 * ���������� ����� ����������
	 *
	 *  0 �����
	 *  13 ������ �����, ��������� ������ �����
	 *  150 ������ ����������� (�������� �����/������)
	 *  210 ���� �� ������
	 *  215 ���� � ����� txn ��� ����������
	 *  241 ����� ������� ����
	 *  242 ��������� ������������ ����� ������� � 15 000�.
	 *  278 ���������� ������������� ��������� ��������� ������ ������
	 *  298 ������ �� ���������� � �������
	 *  300 ����������� ������
	 *  330 ������ ����������
	 *  370 ��������� ������������ ���-�� ������������ ����������� ��������
	 */

	public function action_create() {
		$phone = '7777777777';
		$amount = '0.01';
		$txn = 77;
		$comment = 'test billd';
		$alarm = 0;

		$rc = QIWI::factory()->createBill($phone, $amount, $txn, $comment, $alarm);
		var_dump($rc);
	}

	public function action_cancel() {
		$txn = 4;
		$rc = QIWI::factory()->cancelBill($txn);
		var_dump($rc);
	}

	/**
	 * ���������� �������� ������
	 *
	 * 50 ���������
	 * 52 ����������
	 * 60 �������
	 * 150 ������� (������ �� ���������)
	 * 151 ������� (������ �����������: ������������ ������� �� �������, �������� ��������� ��� ������ � �������� ����� ��������� ������� ����� � �.�.).
	 * 160 �������
	 * 161 ������� (������� �����)
	 */

	public function action_check() {
		$txn = 4;
		$rc = QIWI::factory()->checkBill($txn);
		var_dump($rc);
	}

	public function action_update() {
		QIWI::factory()->updateBill();
	}


}