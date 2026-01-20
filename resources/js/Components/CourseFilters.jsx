import { useState, useEffect } from 'react';
import Dropdown from '@/Components/Dropdown';
import TextInput from '@/Components/TextInput';

const CourseFilters = ({ onFilterChange, filters }) => {
    const [categories, setCategories] = useState([]);
    const [qualifications, setQualifications] = useState([]);
    const [studyModes, setStudyModes] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const fetchFilterOptions = async () => {
            try {
                setLoading(true);
                
                const [categoriesRes, qualificationsRes, studyModesRes] = await Promise.all([
                    fetch('/api/student/categoryFilterList'),
                    fetch('/api/student/qualificationFilterList'),
                    fetch('/api/student/studyModeFilterlist')
                ]);

                const [categoriesData, qualificationsData, studyModesData] = await Promise.all([
                    categoriesRes.json(),
                    qualificationsRes.json(),
                    studyModesRes.json()
                ]);

                if (categoriesData.success) setCategories(categoriesData.data);
                if (qualificationsData.success) setQualifications(qualificationsData.data);
                if (studyModesData.success) setStudyModes(studyModesData.data);
                
            } catch (error) {
                console.error('Error fetching filter options:', error);
            } finally {
                setLoading(false);
            }
        };

        fetchFilterOptions();
    }, []);

    const handleSearchChange = (value) => {
        onFilterChange({ search: value });
    };

    const handleCategoryChange = (categoryId) => {
        onFilterChange({ category: categoryId === 'all' ? null : [categoryId] });
    };

    const handleQualificationChange = (qualificationId) => {
        onFilterChange({ qualification: qualificationId === 'all' ? null : qualificationId });
    };

    const handleStudyModeChange = (studyModeId) => {
        onFilterChange({ studyMode: studyModeId === 'all' ? null : [studyModeId] });
    };

    const handleReset = () => {
        onFilterChange({
            search: '',
            category: null,
            qualification: null,
            studyMode: null
        });
    };

    const getCategoryLabel = () => {
        if (loading) return 'Loading...';
        if (filters.category && filters.category[0]) {
            const category = categories.find(c => c.id === filters.category[0]);
            return category ? category.category_name : 'Category';
        }
        return 'Category';
    };

    const getQualificationLabel = () => {
        if (loading) return 'Loading...';
        if (filters.qualification) {
            const qualification = qualifications.find(q => q.id === filters.qualification);
            return qualification ? qualification.qualification_name : 'Qualification';
        }
        return 'Qualification';
    };

    const getStudyModeLabel = () => {
        if (loading) return 'Loading...';
        if (filters.studyMode && filters.studyMode[0]) {
            const studyMode = studyModes.find(s => s.id === filters.studyMode[0]);
            return studyMode ? studyMode.studyMode_name : 'Study Mode';
        }
        return 'Study Mode';
    };

    return (
        <div className="bg-white shadow-sm rounded-lg p-6 mb-6">
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                {/* Search Bar */}
                <div className="lg:col-span-2">
                    <TextInput
                        placeholder="Search courses..."
                        value={filters.search || ''}
                        onChange={(e) => handleSearchChange(e.target.value)}
                    />
                </div>

                {/* Category Dropdown */}
                <div>
                    <Dropdown>
                        <Dropdown.Trigger>
                            <button className="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm leading-4 font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 w-full justify-between">
                                <span>{getCategoryLabel()}</span>
                                <svg className="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fillRule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clipRule="evenodd" />
                                </svg>
                            </button>
                        </Dropdown.Trigger>
                        <Dropdown.Content width="w-full" align="left" contentClasses="py-1">
                            <button
                                onClick={() => handleCategoryChange('all')}
                                className="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                            >
                                All Categories
                            </button>
                            {categories.map((category) => (
                                <button
                                    key={category.id}
                                    onClick={() => handleCategoryChange(category.id)}
                                    className="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                >
                                    {category.category_name}
                                </button>
                            ))}
                        </Dropdown.Content>
                    </Dropdown>
                </div>

                {/* Qualification Dropdown */}
                <div>
                    <Dropdown>
                        <Dropdown.Trigger>
                            <button className="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm leading-4 font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 w-full justify-between">
                                <span>{getQualificationLabel()}</span>
                                <svg className="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fillRule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clipRule="evenodd" />
                                </svg>
                            </button>
                        </Dropdown.Trigger>
                        <Dropdown.Content width="w-full" align="left" contentClasses="py-1">
                            <button
                                onClick={() => handleQualificationChange('all')}
                                className="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                            >
                                All Qualifications
                            </button>
                            {qualifications.map((qualification) => (
                                <button
                                    key={qualification.id}
                                    onClick={() => handleQualificationChange(qualification.id)}
                                    className="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                >
                                    {qualification.qualification_name}
                                </button>
                            ))}
                        </Dropdown.Content>
                    </Dropdown>
                </div>

                {/* Study Mode Dropdown */}
                <div>
                    <Dropdown>
                        <Dropdown.Trigger>
                            <button className="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm leading-4 font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 w-full justify-between">
                                <span>{getStudyModeLabel()}</span>
                                <svg className="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fillRule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clipRule="evenodd" />
                                </svg>
                            </button>
                        </Dropdown.Trigger>
                        <Dropdown.Content width="w-full" align="left" contentClasses="py-1">
                            <button
                                onClick={() => handleStudyModeChange('all')}
                                className="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                            >
                                All Study Modes
                            </button>
                            {studyModes.map((studyMode) => (
                                <button
                                    key={studyMode.id}
                                    onClick={() => handleStudyModeChange(studyMode.id)}
                                    className="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                >
                                    {studyMode.studyMode_name}
                                </button>
                            ))}
                        </Dropdown.Content>
                    </Dropdown>
                </div>
            </div>

            {/* Reset Button */}
            <div className="mt-4">
                <button
                    onClick={handleReset}
                    className="px-4 py-2 bg-gray-200 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-300 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-gray-500"
                >
                    Reset Filters
                </button>
            </div>
        </div>
    );
};

export default CourseFilters;