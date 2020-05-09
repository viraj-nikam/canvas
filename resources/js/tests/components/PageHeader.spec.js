import { shallowMount } from '@vue/test-utils';
import PageHeader from '../../components/PageHeader';
const { it, expect } = global;

it.skip('is a Vue instance', () => {
    const wrapper = shallowMount(PageHeader);

    expect(wrapper.isVueInstance()).toBeTruthy();
});
