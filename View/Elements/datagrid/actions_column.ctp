<?php
foreach ($actions as $action) {
	if ($action['options']['type'] == 'link') {
		if ($action['options']['method'] == 'post') {
			echo $this->Form->postLink($action['name'], $action['url'], array_merge($action['options'], array('title' => $action['name'])));
		} else {
			echo $this->Html->link($action['name'], $action['url'], array_merge($action['options'], array('title' => $action['name'])));
		}
	}
	elseif ($action['options']['type'] == 'image' && !empty($action['options']['image'])) {
		if ($action['options']['method'] == 'post') {
			echo $this->Form->postLink(
				$this->Html->image($action['options']['image'], array('alt' => $action['name'])),
				$action['url'], array_merge($action['options'], array('escape' => false, 'title' => $action['name']))
			);
		} else {
			echo $this->Html->link(
				$this->Html->image($action['options']['image'], array('alt' => $action['name'])),
				$action['url'], array_merge($action['options'], array('escape' => false, 'title' => $action['name']))
			);
		}
	}
}